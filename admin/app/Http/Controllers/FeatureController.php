<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $features = Feature::query()
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.features.index', compact('features', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.features._drawer', [
                'action' => route('admin.features.store'),
                'submitLabel' => 'Create Feature',
            ]);
        }

        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('icon')) {
            $data['icon_path'] = $request->file('icon')->store('features', 'public');
        }
        unset($data['icon']);

        Feature::create($data);

        return $this->saved($request, 'admin.features.index', 'Feature added successfully.');
    }

    public function edit(Request $request, Feature $feature)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.features._drawer', [
                'feature' => $feature,
                'action' => route('admin.features.update', $feature),
                'method' => 'PUT',
                'submitLabel' => 'Update Feature',
            ]);
        }

        return view('admin.features.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('icon')) {
            if ($feature->icon_path) {
                Storage::disk('public')->delete($feature->icon_path);
            }
            $data['icon_path'] = $request->file('icon')->store('features', 'public');
        }
        unset($data['icon']);

        $feature->update($data);

        return $this->saved($request, 'admin.features.index', 'Feature updated successfully.');
    }

    public function toggle(Feature $feature)
    {
        $feature->update(['is_active' => ! $feature->is_active]);

        return back()->with('success', $feature->title . ' is now ' . ($feature->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(Feature $feature)
    {
        if ($feature->icon_path) {
            Storage::disk('public')->delete($feature->icon_path);
        }

        $feature->delete();

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'icon' => ['nullable', 'file', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
