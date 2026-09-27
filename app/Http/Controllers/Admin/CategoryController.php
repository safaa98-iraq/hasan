<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::orderBy('order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Category::create($data);

        return redirect(admin_route('admin.categories.index'))->with('status', 'Category created.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validated($request, $category);

        $category->update($data);

        return redirect(admin_route('admin.categories.index'))->with('status', 'Category updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect(admin_route('admin.categories.index'))->with('status', 'Category deleted.');
    }

    private function validated(Request $request, ?Category $category = null): array
    {
        $slug = $request->input('slug');
        $title = $request->input('title_en');

        if (($slug === null || is_string($slug)) && is_string($title)) {
            $request->merge(['slug' => Str::slug($slug ?: $title) ?: 'category']);
        }

        $uniqueSlug = 'unique:categories,slug'.($category ? ','.$category->id : '');

        return $request->validate([
            'slug' => ['required', 'string', 'max:255', $uniqueSlug],
            'order' => ['required', 'integer', 'min:0'],
            'roman_numeral' => ['nullable', 'string', 'max:10'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
        ]);
    }
}
