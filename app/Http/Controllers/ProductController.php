<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Kategori; // ✅ FIX (bukan Category)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // ✅ ambil produk + relasi kategori
        $products = Product::with(['user', 'kategori'])->paginate(10);

        // ✅ WAJIB (biar ga error $kategoris)
        $kategoris = Kategori::all();

        return view('product.index', compact('products', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all(); // ✅ FIX
        return view('product.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $isAdmin = auth()->user()->role === 'admin';

        if ($isAdmin) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'kategori_id' => 'required|exists:kategoris,id', // ✅ FIX
            ]);
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
            ]);

            $validated['user_id'] = auth()->id();

            // ✅ kategori default
            $validated['kategori_id'] = Kategori::firstOrCreate([
                'name' => 'Uncategorized'
            ])->id;
        }

        try {
            Product::create($validated);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.');

        } catch (QueryException $e) {
            Log::error('DB Error', ['message' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Database error');

        } catch (\Throwable $e) {
            Log::error('Error', ['message' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Unexpected error');
        }
    }

    public function show($id)
    {
        $product = Product::with('kategori')->findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $users = User::orderBy('name')->get();
        $kategoris = Kategori::all(); // ✅ TAMBAH

        return view('product.edit', compact('product', 'users', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        Gate::authorize('update', $product);

        $isAdmin = auth()->user()->role === 'admin';

        if ($isAdmin) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'kategori_id' => 'required|exists:kategoris,id', // ✅ FIX
            ]);
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
            ]);

            $validated['user_id'] = $product->user_id;
            $validated['kategori_id'] = $product->kategori_id;
        }

        $product->update($validated);

        return redirect()->route('product.index')
            ->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')
            ->with('success', 'Product berhasil dihapus');
    }

    public function export()
    {
        $this->authorize('export-product');
        return response()->json(['message' => 'Export jalan']);
    }
}