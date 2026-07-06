<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyInfoController extends Controller
{
    public function edit()
    {
        $company = CompanyInfo::current();

        return view('admin.company.edit', compact('company'));
    }

    /**
     * Public JSON feed for site-wide widgets (WhatsApp button + Tawk.to chat),
     * consumed by a small script that runs on every page (static + dynamic).
     */
    public function widgets()
    {
        $company = CompanyInfo::current();

        return response()->json([
            'whatsapp' => preg_replace('/[^0-9]/', '', (string) $company->whatsapp),
            'whatsapp_message' => $company->whatsapp_message,
            'tawkto_src' => $company->tawkto_src,
            // Same phone number shown in the website footer → floating call button.
            'phone' => preg_replace('/[^0-9+]/', '', (string) $company->phone),
        ]);
    }

    public function update(Request $request)
    {
        $company = CompanyInfo::current();

        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'parent_company' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'tickets_phone' => ['nullable', 'string', 'max:30'],
            'tickets_email' => ['nullable', 'email', 'max:255'],
            'packages_phone' => ['nullable', 'string', 'max:30'],
            'packages_email' => ['nullable', 'email', 'max:255'],
            'visa_phone' => ['nullable', 'string', 'max:30'],
            'visa_email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'payment_url' => ['nullable', 'url', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:120'],
            'state' => ['nullable', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:120'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'gst_number' => ['nullable', 'string', 'max:50'],
            'registration_number' => ['nullable', 'string', 'max:50'],
            'license_no' => ['nullable', 'string', 'max:50'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'about' => ['nullable', 'string', 'max:5000'],
            'map_embed' => ['nullable', 'string', 'max:5000'],
            'tawkto_src' => ['nullable', 'string', 'max:255'],
            'whatsapp_message' => ['nullable', 'string', 'max:255'],
            'mail_host' => ['nullable', 'string', 'max:255'],
            'mail_port' => ['nullable', 'string', 'max:10'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['nullable', 'in:tls,ssl'],
            'mail_from_address' => ['nullable', 'email', 'max:255'],
            'mail_from_name' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,ico,svg', 'max:1024'],
            'menu_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'cta_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('company', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($company->favicon_path) {
                Storage::disk('public')->delete($company->favicon_path);
            }
            $data['favicon_path'] = $request->file('favicon')->store('company', 'public');
        }

        if ($request->hasFile('menu_image')) {
            if ($company->menu_image_path) {
                Storage::disk('public')->delete($company->menu_image_path);
            }
            $data['menu_image_path'] = $request->file('menu_image')->store('company', 'public');
        }

        if ($request->hasFile('cta_image')) {
            if ($company->cta_image_path) {
                Storage::disk('public')->delete($company->cta_image_path);
            }
            $data['cta_image_path'] = $request->file('cta_image')->store('company', 'public');
        }

        unset($data['logo'], $data['favicon'], $data['menu_image'], $data['cta_image']);

        $company->update($data);

        return redirect()->route('admin.company.edit')
            ->with('success', 'Company information saved successfully.');
    }
}
