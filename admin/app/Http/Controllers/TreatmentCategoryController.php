<?php

namespace App\Http\Controllers;

use App\Models\TreatmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TreatmentCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $categories = TreatmentCategory::query()
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.treatment_categories.index', compact('categories', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.treatment_categories._drawer', [
                'action' => route('admin.treatment-categories.store'),
                'submitLabel' => 'Create Category',
            ]);
        }

        return view('admin.treatment_categories.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('categories', 'public');
        }
        unset($data['image']);

        TreatmentCategory::create($data);

        return $this->saved($request, 'admin.treatment-categories.index', 'Category added successfully.');
    }

    public function edit(Request $request, TreatmentCategory $treatmentCategory)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.treatment_categories._drawer', [
                'category' => $treatmentCategory,
                'action' => route('admin.treatment-categories.update', $treatmentCategory),
                'method' => 'PUT',
                'submitLabel' => 'Update Category',
            ]);
        }

        return view('admin.treatment_categories.edit', ['category' => $treatmentCategory]);
    }

    public function update(Request $request, TreatmentCategory $treatmentCategory)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name'], $treatmentCategory->id);

        if ($request->hasFile('image')) {
            if ($treatmentCategory->image_path) {
                Storage::disk('public')->delete($treatmentCategory->image_path);
            }
            $data['image_path'] = $request->file('image')->store('categories', 'public');
        }
        unset($data['image']);

        $treatmentCategory->update($data);

        return $this->saved($request, 'admin.treatment-categories.index', 'Category updated successfully.');
    }

    public function toggle(TreatmentCategory $treatmentCategory)
    {
        $treatmentCategory->update(['is_active' => ! $treatmentCategory->is_active]);

        return back()->with('success', $treatmentCategory->name . ' is now ' . ($treatmentCategory->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(TreatmentCategory $treatmentCategory)
    {
        $treatmentCategory->delete();

        return redirect()->route('admin.treatment-categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'image' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    /** Build a slug from the name that is unique among treatment categories. */
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'category';
        $slug = $base;
        $i = 1;

        while (TreatmentCategory::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }
}
