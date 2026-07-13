<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function edit()
    {
        $hero = HeroSection::current();

        return view('admin.hero.edit', compact('hero'));
    }

    public function update(Request $request)
    {
        $hero = HeroSection::current();

        $data = $request->validate([
            'punchline' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'mobile_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'inner_banner' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($hero->image_path) {
                Storage::disk('public')->delete($hero->image_path);
            }
            $data['image_path'] = $request->file('image')->store('hero', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            if ($hero->mobile_image_path) {
                Storage::disk('public')->delete($hero->mobile_image_path);
            }
            $data['mobile_image_path'] = $request->file('mobile_image')->store('hero', 'public');
        }

        if ($request->hasFile('inner_banner')) {
            if ($hero->inner_banner_path) {
                Storage::disk('public')->delete($hero->inner_banner_path);
            }
            $data['inner_banner_path'] = $request->file('inner_banner')->store('hero', 'public');
        }

        unset($data['image'], $data['mobile_image'], $data['inner_banner']);

        $hero->update($data);

        return redirect()->route('admin.hero.edit')
            ->with('success', 'Hero section saved successfully.');
    }

    /**
     * Public JSON feed consumed by the static website's hero section.
     */
    public function api()
    {
        $hero = HeroSection::current();

        return response()->json([
            'punchline' => $hero->punchline,
            'description' => $hero->description,
            'image_url' => $hero->image_url,
        ]);
    }
}
