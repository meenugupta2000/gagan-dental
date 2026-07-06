<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSectionController extends Controller
{
    // -----------------------------------------------------------------
    // Public website
    // -----------------------------------------------------------------

    /** Public "About" page. */
    public function page()
    {
        $about = AboutSection::current();
        $features = Feature::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

        return view('about', compact('about', 'features'));
    }

    // -----------------------------------------------------------------
    // Admin panel
    // -----------------------------------------------------------------

    public function edit()
    {
        $about = AboutSection::current();

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $about = AboutSection::current();

        $data = $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],

            'doctor_name' => ['nullable', 'string', 'max:255'],
            'doctor_title' => ['nullable', 'string', 'max:255'],
            'doctor_photo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:100'],
            'clinic_since' => ['nullable', 'string', 'max:20'],

            'intro' => ['nullable', 'string', 'max:2000'],
            'body' => ['nullable', 'string', 'max:20000'],
            'qualifications' => ['nullable', 'string', 'max:2000'],
            'philosophy' => ['nullable', 'string', 'max:2000'],

            'stat1_value' => ['nullable', 'string', 'max:20'],
            'stat1_label' => ['nullable', 'string', 'max:60'],
            'stat2_value' => ['nullable', 'string', 'max:20'],
            'stat2_label' => ['nullable', 'string', 'max:60'],
            'stat3_value' => ['nullable', 'string', 'max:20'],
            'stat3_label' => ['nullable', 'string', 'max:60'],
            'stat4_value' => ['nullable', 'string', 'max:20'],
            'stat4_label' => ['nullable', 'string', 'max:60'],
        ]);

        if ($request->hasFile('doctor_photo')) {
            if ($about->doctor_photo_path) {
                Storage::disk('public')->delete($about->doctor_photo_path);
            }
            $data['doctor_photo_path'] = $request->file('doctor_photo')->store('about', 'public');
        }
        unset($data['doctor_photo']);

        $about->update($data);

        return redirect()->route('admin.about.edit')
            ->with('success', 'About section saved successfully.');
    }
}
