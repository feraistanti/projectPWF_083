<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests; // Tambahkan ini juga di dalam class 

    public function index()
    {
        // Mengambil data dengan pembagian 10 data per halaman
        $products = Product::with('user')->paginate(10); 
        return view('product.index', compact('products'));
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
                'category_id' => 'required|exists:categories,id',
            ],[
                'name.required' => 'Nama produk wajib diisi.',
                'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
                'quantity.required' => 'Jumlah (kuantitas) produk wajib diisi.',
                'quantity.integer' => 'Jumlah produk harus berupa angka bulat (tidak boleh desimal).',
                'price.required' => 'Harga produk wajib diisi.',
                'price.numeric' => 'Harga produk harus berupa angka yang valid.',
            ]);
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
            ], [
                'name.required' => 'Nama produk wajib diisi.',
            ]);
            $validated['user_id'] = auth()->id();
            $validated['category_id'] = Category::firstOrCreate(['name' => 'Uncategorized'])->id;
        }

        try {
        Product::create($validated);

        return redirect()
            ->route('product.index')
            ->with('success', 'Product created successfully.');
            
    } catch (QueryException $e) {
        Log::error('Product store database error', [
            'message' => $e->getMessage(),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Database error while creating product.');
            
    } catch (\Throwable $e) {
        Log::error('Product store unexpected error', [
            'message' => $e->getMessage(),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Unexpected error occurred.');
    }
}

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('product.create', compact('users'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.view', compact('product'));
    }

    // --- BAGIAN EDIT DENGAN POLICY ---
    public function edit(Product $product)
    {
        $this->authorize('update', $product); // Cek apakah boleh edit
        
        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    // --- BAGIAN UPDATE DENGAN POLICY ---
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Minta izin ke Policy
        Gate::authorize('update', $product);

        $isAdmin = auth()->user()->role === 'admin';

        if ($isAdmin) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'category_id' => 'required|exists:categories,id',
            ], [
                'name.required' => 'Nama produk wajib diisi.',
                'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
                'quantity.required' => 'Jumlah (kuantitas) produk wajib diisi.',
                'quantity.integer' => 'Jumlah produk harus berupa angka bulat (tidak boleh desimal).',
                'price.required' => 'Harga produk wajib diisi.',
                'price.numeric' => 'Harga produk harus berupa angka yang valid.',
            ]);

        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
            ]);
            $validated['user_id'] = $product->user_id;
            $validated['category_id'] = $product->category_id;
        }

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    // --- BAGIAN DELETE DENGAN POLICY ---
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product); // Cek apakah boleh hapus

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }

    // Fungsi tambahan untuk export (Tugas Kelas B)
    public function export()
    {
        $this->authorize('export-product'); // Cek Gate export
        // Logika export kamu di sini (misal download excel)
        return response()->json(['message' => 'Fungsi export berhasil dipanggil!']);
    }
}