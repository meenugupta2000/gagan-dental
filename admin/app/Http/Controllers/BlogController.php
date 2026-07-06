<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $blogs = Blog::query()
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.blogs.index', compact('blogs', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.blogs._drawer', [
                'action' => route('admin.blogs.store'),
                'submitLabel' => 'Create Blog',
            ]);
        }

        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['slug'] = $this->uniqueSlug($data['title']);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('blogs', 'public');
        }
        unset($data['image']);

        Blog::create($data);

        return $this->saved($request, 'admin.blogs.index', 'Blog added successfully.');
    }

    public function edit(Request $request, Blog $blog)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.blogs._drawer', [
                'blog' => $blog,
                'action' => route('admin.blogs.update', $blog),
                'method' => 'PUT',
                'submitLabel' => 'Update Blog',
            ]);
        }

        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $this->validateData($request);

        $data['slug'] = $this->uniqueSlug($data['title'], $blog->id);
        if ($request->hasFile('image')) {
            if ($blog->image_path) {
                Storage::disk('public')->delete($blog->image_path);
            }
            $data['image_path'] = $request->file('image')->store('blogs', 'public');
        }
        unset($data['image']);

        $blog->update($data);

        return $this->saved($request, 'admin.blogs.index', 'Blog updated successfully.');
    }

    public function toggle(Blog $blog)
    {
        $blog->update(['is_active' => ! $blog->is_active]);

        return back()->with('success', $blog->title . ' is now ' . ($blog->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    /** Public blog listing page (active blogs only). */
    public function page()
    {
        $blogs = Blog::where('is_active', true)->orderBy('sort_order')->orderByDesc('id')->get();

        return view('blog.index', compact('blogs'));
    }

    /** Public single-blog page. */
    public function show(string $slug)
    {
        $blog = Blog::where('is_active', true)->where('slug', $slug)->firstOrFail();
        $allBlogs = Blog::where('is_active', true)->orderBy('sort_order')->orderByDesc('id')->get();

        return view('blog.show', compact('blog', 'allBlogs'));
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'image' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    /** Build a slug from the title that is unique among blogs. */
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'blog';
        $slug = $base;
        $i = 1;

        while (Blog::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }
}
