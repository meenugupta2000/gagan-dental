<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $offers = Offer::query()
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.offers.index', compact('offers', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.offers._drawer', [
                'action' => route('admin.offers.store'),
                'submitLabel' => 'Create Offer',
            ]);
        }

        return view('admin.offers.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('offers', 'public');
        }
        unset($data['image']);

        Offer::create($data);

        return $this->saved($request, 'admin.offers.index', 'Offer added successfully.');
    }

    public function edit(Request $request, Offer $offer)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.offers._drawer', [
                'offer' => $offer,
                'action' => route('admin.offers.update', $offer),
                'method' => 'PUT',
                'submitLabel' => 'Update Offer',
            ]);
        }

        return view('admin.offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($offer->image_path) {
                Storage::disk('public')->delete($offer->image_path);
            }
            $data['image_path'] = $request->file('image')->store('offers', 'public');
        }
        unset($data['image']);

        $offer->update($data);

        return $this->saved($request, 'admin.offers.index', 'Offer updated successfully.');
    }

    public function toggle(Offer $offer)
    {
        $offer->update(['is_active' => ! $offer->is_active]);

        return back()->with('success', $offer->title . ' is now ' . ($offer->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(Offer $offer)
    {
        if ($offer->image_path) {
            Storage::disk('public')->delete($offer->image_path);
        }

        $offer->delete();

        return redirect()->route('admin.offers.index')
            ->with('success', 'Offer deleted successfully.');
    }

    /**
     * Public "Offers" page on the website (active offers only).
     */
    public function page()
    {
        $offers = Offer::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

        return view('offers', compact('offers'));
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'image' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
