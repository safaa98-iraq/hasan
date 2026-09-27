<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class ContactSettingController extends Controller
{
    public function edit()
    {
        $contact = Page::where('key', 'contact_email')->first();

        return view('admin.settings', [
            'email_en' => $contact?->title_en ?? config('site.contact_email_en'),
            'email_ar' => $contact?->title_ar ?? config('site.contact_email_ar'),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'email_en' => ['present', 'nullable', 'email', 'max:255'],
            'email_ar' => ['present', 'nullable', 'email', 'max:255'],
        ]);
        Page::updateOrCreate(['key' => 'contact_email'], ['title_en' => $data['email_en'], 'title_ar' => $data['email_ar']]);

        return redirect(admin_route('admin.settings.edit'))->with('status', 'Contact email saved.');
    }
}
