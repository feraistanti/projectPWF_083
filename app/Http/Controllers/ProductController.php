<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // Pastikan relasi di model Product bernama 'category'
        $products = Product::with(['user', 'category'])->latest()->paginate(10);
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $isAdmin = auth()->user()->role === 'admin';
        return view('product.create', compact('categories', 'isAdmin'));
    }

    public function store(Request $request)
    {
        $isAdmin = auth()->user()->role === 'admin';

        $rules = [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ];

        if ($isAdmin) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        if (!$isAdmin) {
            $validated['user_id'] = auth()->id();
        }

        // Mapping category_id ke kategori_id untuk database
        $validated['kategori_id'] = $validated['category_id'];
        unset($validated['category_id']);

        try {
            Product::create($validated);
            return redirect()->route('product.index')->with('success', 'Produk berhasil ditambah!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $users = User::all();
        $categories = Category::all();
        $isAdmin = auth()->user()->role === 'admin';

        return view('product.edit', compact('product', 'users', 'categories', 'isAdmin'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        $isAdmin = auth()->user()->role === 'admin';

        $rules = [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ];

        if ($isAdmin) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        // --- PERBAIKAN ERROR SQL ---
        // Pindahkan nilai dari input 'category_id' ke kolom 'kategori_id'
        $validated['kategori_id'] = $validated['category_id'];
        
        // Hapus 'category_id' agar Laravel tidak mencari kolom tersebut di DB
        unset($validated['category_id']);

        try {
            $product->update($validated);
            return redirect()->route('product.index')->with('success', 'Produk diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function delete(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Produk dihapus!');
    }
}