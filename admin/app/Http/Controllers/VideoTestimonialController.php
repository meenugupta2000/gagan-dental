<?php

namespace App\Http\Controllers;

use App\Models\VideoTestimonial;
use Illuminate\Http\Request;

class VideoTestimonialController extends Controller
{
    // -----------------------------------------------------------------
    // Public website
    // -----------------------------------------------------------------

    /** Public "Testimonials" page — active video testimonials in order. */
    public function page()
    {
        $videos = VideoTestimonial::where('is_active', true)
            ->orderBy('sort_order')->orderByDesc('id')
            ->get();

        return view('testimonials', compact('videos'));
    }

    // -----------------------------------------------------------------
    // Admin panel
    // -----------------------------------------------------------------

    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $videos = VideoTestimonial::query()
            ->when($search, fn ($q) => $q->where('heading', 'like', "%{$search}%"))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.video_testimonials.index', compact('videos', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.video_testimonials._drawer', [
                'action' => route('admin.video-testimonials.store'),
                'submitLabel' => 'Create Video Testimonial',
            ]);
        }

        return view('admin.video_testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        VideoTestimonial::create($data);

        return $this->saved($request, 'admin.video-testimonials.index', 'Video testimonial added successfully.');
    }

    public function edit(Request $request, VideoTestimonial $videoTestimonial)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.video_testimonials._drawer', [
                'videoTestimonial' => $videoTestimonial,
                'action' => route('admin.video-testimonials.update', $videoTestimonial),
                'method' => 'PUT',
                'submitLabel' => 'Update Video Testimonial',
            ]);
        }

        return view('admin.video_testimonials.edit', compact('videoTestimonial'));
    }

    public function update(Request $request, VideoTestimonial $videoTestimonial)
    {
        $data = $this->validateData($request);

        $videoTestimonial->update($data);

        return $this->saved($request, 'admin.video-testimonials.index', 'Video testimonial updated successfully.');
    }

    public function toggle(VideoTestimonial $videoTestimonial)
    {
        $videoTestimonial->update(['is_active' => ! $videoTestimonial->is_active]);

        return back()->with('success', $videoTestimonial->heading . ' is now ' . ($videoTestimonial->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(VideoTestimonial $videoTestimonial)
    {
        $videoTestimonial->delete();

        return redirect()->route('admin.video-testimonials.index')
            ->with('success', 'Video testimonial deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'heading' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'youtube_url' => ['required', 'string', 'max:255', 'regex:#(youtube\.com|youtu\.be)#i'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ], [
            'youtube_url.regex' => 'Please enter a valid YouTube link (youtube.com or youtu.be).',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
