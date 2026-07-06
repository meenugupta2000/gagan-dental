<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // -----------------------------------------------------------------
    // Public website
    // -----------------------------------------------------------------

    /** Public "FAQs" page — active FAQs in order. */
    public function page()
    {
        $faqs = Faq::where('is_active', true)
            ->orderBy('sort_order')->orderBy('id')
            ->get();

        return view('faqs', compact('faqs'));
    }

    // -----------------------------------------------------------------
    // Admin panel
    // -----------------------------------------------------------------

    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $faqs = Faq::query()
            ->when($search, fn ($q) => $q->where('question', 'like', "%{$search}%"))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.faqs.index', compact('faqs', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.faqs._drawer', [
                'action' => route('admin.faqs.store'),
                'submitLabel' => 'Create FAQ',
            ]);
        }

        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        Faq::create($data);

        return $this->saved($request, 'admin.faqs.index', 'FAQ added successfully.');
    }

    public function edit(Request $request, Faq $faq)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.faqs._drawer', [
                'faq' => $faq,
                'action' => route('admin.faqs.update', $faq),
                'method' => 'PUT',
                'submitLabel' => 'Update FAQ',
            ]);
        }

        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $this->validateData($request);

        $faq->update($data);

        return $this->saved($request, 'admin.faqs.index', 'FAQ updated successfully.');
    }

    public function toggle(Faq $faq)
    {
        $faq->update(['is_active' => ! $faq->is_active]);

        return back()->with('success', 'FAQ is now ' . ($faq->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string', 'max:5000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
