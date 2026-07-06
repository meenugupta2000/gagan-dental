<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /** All known placeholder descriptions. */
    public const ALL_PLACEHOLDERS = [
        'name' => "Visitor's name",
        'email' => "Visitor's email",
        'phone' => "Visitor's phone",
        'subject' => 'Enquiry subject',
        'message' => 'The message text',
        'company_name' => 'Your company name',
    ];

    /** Which placeholders apply to each template key. */
    public const TEMPLATE_PLACEHOLDERS = [
        'contact_confirmation' => ['name', 'email', 'phone', 'subject', 'message', 'company_name'],
        'contact_admin' => ['name', 'email', 'phone', 'subject', 'message', 'company_name'],
        'newsletter_welcome' => ['email', 'company_name'],
    ];

    public function index()
    {
        $templates = EmailTemplate::orderBy('name')->get();

        return view('admin.templates.index', compact('templates'));
    }

    public function edit(EmailTemplate $template)
    {
        $keys = self::TEMPLATE_PLACEHOLDERS[$template->key] ?? array_keys(self::ALL_PLACEHOLDERS);
        $placeholders = collect($keys)->mapWithKeys(fn ($k) => [$k => self::ALL_PLACEHOLDERS[$k] ?? $k])->all();

        return view('admin.templates.edit', compact('template', 'placeholders'));
    }

    public function update(Request $request, EmailTemplate $template)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $template->update($data);

        return redirect()->route('admin.templates.index')
            ->with('success', $template->name . ' updated successfully.');
    }
}
