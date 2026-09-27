<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\UploadsImages;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use UploadsImages;

    public function index()
    {
        return view('admin.pages.index', [
            'pages' => Page::where('key', '!=', 'contact_email')->orderBy('key')->get(),
        ]);
    }

    public function edit(Page $page)
    {
        abort_if($page->key === 'contact_email', 404);

        return view('admin.pages.edit', [
            'page' => $page,
            'imageUrl' => $this->imageUrl($page->image_path),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        abort_if($page->key === 'contact_email', 404);
        $data = $request->validate([
            'title_en' => ['nullable', 'string'],
            'title_ar' => ['nullable', 'string'],
            'body_en' => ['nullable', 'string'],
            'body_ar' => ['nullable', 'string'],
            'image_path' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['image_path'] = $this->storeImage($request, 'pages', $page->image_path);

        $page->update($data);

        return redirect(admin_route('admin.pages.edit', $page))->with('status', 'Page updated.');
    }
}
