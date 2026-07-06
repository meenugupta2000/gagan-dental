<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderByDesc('id')->paginate(config('admin.per_page'));

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_active'] = $request->boolean('is_active');

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page added successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Slug stays fixed on update so footer / shared links never break.
        $data['is_active'] = $request->boolean('is_active');

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page saved successfully.');
    }

    public function toggle(Page $page)
    {
        $page->update(['is_active' => ! $page->is_active]);

        return back()->with('success', $page->title . ' is now ' . ($page->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }

    /** Public page (Privacy Policy, Terms & Conditions, etc.). */
    public function show(string $slug)
    {
        $page = Page::where('is_active', true)->where('slug', $slug)->firstOrFail();

        return view('page.show', compact('page'));
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'page';
        $slug = $base;
        $i = 1;

        while (Page::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }
}
