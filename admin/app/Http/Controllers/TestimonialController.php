<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $testimonials = Testimonial::query()
            ->when($search, fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%")
                ->orWhere('headline', 'like', "%{$search}%")))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.testimonials.index', compact('testimonials', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.testimonials._drawer', [
                'action' => route('admin.testimonials.store'),
                'submitLabel' => 'Create Testimonial',
            ]);
        }

        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('testimonials', 'public');
        }
        unset($data['photo']);

        Testimonial::create($data);

        return $this->saved($request, 'admin.testimonials.index', 'Testimonial added successfully.');
    }

    public function edit(Request $request, Testimonial $testimonial)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.testimonials._drawer', [
                'testimonial' => $testimonial,
                'action' => route('admin.testimonials.update', $testimonial),
                'method' => 'PUT',
                'submitLabel' => 'Update Testimonial',
            ]);
        }

        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('photo')) {
            if ($testimonial->photo_path) {
                Storage::disk('public')->delete($testimonial->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('testimonials', 'public');
        }
        unset($data['photo']);

        $testimonial->update($data);

        return $this->saved($request, 'admin.testimonials.index', 'Testimonial updated successfully.');
    }

    public function toggle(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => ! $testimonial->is_active]);

        return back()->with('success', $testimonial->name . ' is now ' . ($testimonial->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->photo_path) {
            Storage::disk('public')->delete($testimonial->photo_path);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string', 'max:1500'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'photo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        $data['rating'] = $data['rating'] ?? 5;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
