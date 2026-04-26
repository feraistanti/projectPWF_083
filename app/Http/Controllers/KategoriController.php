<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori; // ✅ WAJIB ADA
use Illuminate\Support\Facades\Gate;

class KategoriController extends Controller
{
    // ✅ TARUH DI SINI
    public function __construct()
    {
        $this->middleware('can:manage-kategori');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product.kategori_index', compact('kategoris')); 

    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Kategori::create([
            'name' => $request->name
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'name' => 'required'
        ]);

        $kategori->update([
            'name' => $request->name
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}