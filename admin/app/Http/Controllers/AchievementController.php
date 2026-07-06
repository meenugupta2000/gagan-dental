<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    // -----------------------------------------------------------------
    // Public website
    // -----------------------------------------------------------------

    /** Public "Achievements" page — active achievements in order. */
    public function page()
    {
        $achievements = Achievement::where('is_active', true)
            ->orderBy('sort_order')->orderBy('id')
            ->get();

        return view('achievements', compact('achievements'));
    }

    // -----------------------------------------------------------------
    // Admin panel
    // -----------------------------------------------------------------

    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $achievements = Achievement::query()
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.achievements.index', compact('achievements', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.achievements._drawer', [
                'action' => route('admin.achievements.store'),
                'submitLabel' => 'Create Achievement',
            ]);
        }

        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('achievements', 'public');
        }
        unset($data['image']);

        Achievement::create($data);

        return $this->saved($request, 'admin.achievements.index', 'Achievement added successfully.');
    }

    public function edit(Request $request, Achievement $achievement)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.achievements._drawer', [
                'achievement' => $achievement,
                'action' => route('admin.achievements.update', $achievement),
                'method' => 'PUT',
                'submitLabel' => 'Update Achievement',
            ]);
        }

        return view('admin.achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($achievement->image_path) {
                Storage::disk('public')->delete($achievement->image_path);
            }
            $data['image_path'] = $request->file('image')->store('achievements', 'public');
        }
        unset($data['image']);

        $achievement->update($data);

        return $this->saved($request, 'admin.achievements.index', 'Achievement updated successfully.');
    }

    public function toggle(Achievement $achievement)
    {
        $achievement->update(['is_active' => ! $achievement->is_active]);

        return back()->with('success', $achievement->title . ' is now ' . ($achievement->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(Achievement $achievement)
    {
        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
