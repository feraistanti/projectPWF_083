<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-category');

        // Mengambil kategori beserta jumlah produk di dalamnya
        $categories = Category::withCount('products')->latest()->get();

        // Diperbaiki: Menggunakan 'Category.index' (C Kapital) sesuai folder di VS Code kamu
        return view('Category.index', compact('categories'));
    }

    public function create()
    {
        Gate::authorize('manage-category');

        // Diperbaiki: Menggunakan 'Category.create'
        return view('Category.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-category');

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('category.index')->with('success', 'Category berhasil ditambahkan.');
    }

    public function edit($id)
    {
        Gate::authorize('manage-category');

        $category = Category::findOrFail($id);

        // Diperbaiki: Menggunakan 'Category.edit'
        return view('Category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('manage-category');

        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('category.index')->with('success', 'Category berhasil diupdate.');
    }

    public function destroy($id)
    {
        Gate::authorize('manage-category');

        $category = Category::findOrFail($id);

        // Optimasi: Cek apakah kategori masih digunakan oleh produk sebelum dihapus
        if ($category->products()->count() > 0) {
            return redirect()->route('category.index')->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
        }

        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category berhasil dihapus.');
    }
}