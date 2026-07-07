<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\TreatmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TreatmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $treatments = Treatment::query()
            ->with(['category', 'images'])
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.treatments.index', compact('treatments', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.treatments._drawer', array_merge($this->formData(), [
                'action' => route('admin.treatments.store'),
                'submitLabel' => 'Create Treatment',
            ]));
        }

        return view('admin.treatments.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        unset($data['images'], $data['remove_images']);

        $treatment = Treatment::create($data);
        $this->syncImages($treatment, $request);

        return $this->saved($request, 'admin.treatments.index', 'Treatment added successfully.');
    }

    public function edit(Request $request, Treatment $treatment)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.treatments._drawer', array_merge($this->formData(), [
                'treatment' => $treatment,
                'action' => route('admin.treatments.update', $treatment),
                'method' => 'PUT',
                'submitLabel' => 'Update Treatment',
            ]));
        }

        return view('admin.treatments.edit', array_merge($this->formData(), ['treatment' => $treatment]));
    }

    public function update(Request $request, Treatment $treatment)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name'], $treatment->id);
        unset($data['images'], $data['remove_images']);

        $treatment->update($data);
        $this->syncImages($treatment, $request);

        return $this->saved($request, 'admin.treatments.index', 'Treatment updated successfully.');
    }

    public function toggle(Treatment $treatment)
    {
        $treatment->update(['is_active' => ! $treatment->is_active]);

        return back()->with('success', $treatment->name . ' is now ' . ($treatment->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(Treatment $treatment)
    {
        // Gallery image files are removed via the model's deleting events.
        $treatment->delete();

        return redirect()->route('admin.treatments.index')
            ->with('success', 'Treatment deleted successfully.');
    }

    /** Public "Treatments" listing page (optionally filtered by ?group= and/or ?category=). */
    public function page(Request $request)
    {
        $activeGroup = $request->string('group')->toString() ?: null;
        if ($activeGroup && ! array_key_exists($activeGroup, TreatmentCategory::GROUPS)) {
            $activeGroup = null;
        }

        $categories = TreatmentCategory::where('is_active', true)
            ->when($activeGroup, fn ($q) => $q->where('group', $activeGroup))
            ->orderBy('sort_order')->orderBy('name')
            ->get();

        $activeCategory = $request->string('category')->toString() ?: null;

        $treatments = Treatment::query()
            ->where('is_active', true)
            ->with(['category', 'images'])
            ->when($activeCategory, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $activeCategory)))
            ->when($activeGroup, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('group', $activeGroup)))
            ->orderBy('sort_order')->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('treatments', compact('categories', 'treatments', 'activeCategory', 'activeGroup'));
    }

    /** Public single-treatment detail page. */
    public function show(string $slug)
    {
        $treatment = Treatment::where('is_active', true)->where('slug', $slug)
            ->with(['category', 'images'])
            ->firstOrFail();

        $related = Treatment::where('is_active', true)
            ->where('id', '!=', $treatment->id)
            ->where('treatment_category_id', $treatment->treatment_category_id)
            ->with('images')
            ->orderBy('sort_order')->orderBy('name')
            ->take(3)->get();

        return view('treatment-show', compact('treatment', 'related'));
    }

    /** Dropdown options shared by the create/edit forms. */
    private function formData(): array
    {
        return [
            'categories' => TreatmentCategory::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get(),
        ];
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:120'],
            'treatment_category_id' => ['nullable', 'exists:treatment_categories,id'],
            'badge' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'images' => ['nullable', 'array', 'max:30'],
            'images.*' => ['file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['integer'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        $data['show_on_home'] = $request->boolean('show_on_home');
        $data['treatment_category_id'] = $data['treatment_category_id'] ?? null;

        return $data;
    }

    /** Add newly-uploaded images and remove any marked for deletion. */
    private function syncImages(Treatment $treatment, Request $request): void
    {
        foreach ((array) $request->input('remove_images', []) as $id) {
            // $img->delete() triggers the model event that removes the file.
            $treatment->images()->whereKey($id)->first()?->delete();
        }

        if ($request->hasFile('images')) {
            $order = (int) $treatment->images()->max('sort_order');
            foreach ($request->file('images') as $file) {
                $path = $file->store('treatments', 'public');
                $treatment->images()->create(['image_path' => $path, 'sort_order' => ++$order]);
            }
        }
    }

    /** Build a slug from the name that is unique among treatments. */
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'treatment';
        $slug = $base;
        $i = 1;

        while (Treatment::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }
}
