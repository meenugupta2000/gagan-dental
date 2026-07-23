<?php

namespace App\Http\Controllers;

use App\Models\MediaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaItemController extends Controller
{
    // -----------------------------------------------------------------
    // Public website
    // -----------------------------------------------------------------

    /** Public "Media Gallery" page — active items in order. */
    public function page()
    {
        $media = MediaItem::where('is_active', true)
            ->orderBy('sort_order')->orderBy('id')
            ->get();

        return view('media', compact('media'));
    }

    // -----------------------------------------------------------------
    // Admin panel
    // -----------------------------------------------------------------

    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $media = MediaItem::query()
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.media.index', compact('media', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.media._drawer', [
                'action' => route('admin.media.store'),
                'submitLabel' => 'Create Item',
            ]);
        }

        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request, true);

        $data['image_path'] = $request->file('image')->store('media', 'public');
        unset($data['image']);

        MediaItem::create($data);

        return $this->saved($request, 'admin.media.index', 'Media item added successfully.');
    }

    public function edit(Request $request, MediaItem $mediaItem)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.media._drawer', [
                'item' => $mediaItem,
                'action' => route('admin.media.update', $mediaItem),
                'method' => 'PUT',
                'submitLabel' => 'Update Item',
            ]);
        }

        return view('admin.media.edit', ['item' => $mediaItem]);
    }

    public function update(Request $request, MediaItem $mediaItem)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($mediaItem->image_path) {
                Storage::disk('public')->delete($mediaItem->image_path);
            }
            $data['image_path'] = $request->file('image')->store('media', 'public');
        }
        unset($data['image']);

        $mediaItem->update($data);

        return $this->saved($request, 'admin.media.index', 'Media item updated successfully.');
    }

    public function toggle(MediaItem $mediaItem)
    {
        $mediaItem->update(['is_active' => ! $mediaItem->is_active]);

        return back()->with('success', $mediaItem->title . ' is now ' . ($mediaItem->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(MediaItem $mediaItem)
    {
        $mediaItem->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Media item deleted successfully.');
    }

    private function validateData(Request $request, bool $requireImage = false): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => [$requireImage ? 'required' : 'nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
