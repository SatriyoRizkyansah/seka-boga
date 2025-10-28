<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Models\GambarProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Produk::with(['kategori', 'gambarProduk']);
        
        // Filter by category
        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }
        
        // Filter by status
        if ($request->status !== null) {
            $query->where('aktif', $request->status);
        }
        
        // Search
        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }
        
        $produk = $query->latest()->paginate(10);
        $kategori = KategoriProduk::where('aktif', true)->get();
        
        return view('admin.produk.index', compact('produk', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = KategoriProduk::where('aktif', true)->get();
        return view('admin.produk.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_produk,id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'aktif' => 'boolean',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only([
            'nama_produk', 
            'deskripsi',
            'harga',
            'stok'
        ]);
        $data['kategori_produk_id'] = $request->kategori_id; // Map kategori_id to kategori_produk_id
        $data['aktif'] = $request->has('aktif');

        $produk = Produk::create($data);

        // Handle multiple images
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $key => $file) {
                $path = $file->store('produk', 'public');
                GambarProduk::create([
                    'produk_id' => $produk->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path_gambar' => $path,
                    'gambar_utama' => $key === 0, // First image as main
                    'urutan' => $key + 1
                ]);
            }
        }

        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        $produk->load(['kategori', 'gambarProduk', 'detailPesanan']);
        return view('admin.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $kategori = KategoriProduk::where('aktif', true)->get();
        $produk->load('gambarProduk');
        return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_produk,id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'aktif' => 'boolean',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only([
            'nama_produk', 
            'deskripsi',
            'harga',
            'stok'
        ]);
        $data['kategori_produk_id'] = $request->kategori_id; // Map kategori_id to kategori_produk_id
        $data['aktif'] = $request->has('aktif');

        $produk->update($data);

        // Handle new images
        if ($request->hasFile('gambar')) {
            $maxOrder = $produk->gambarProduk()->max('urutan') ?? 0;
            foreach ($request->file('gambar') as $key => $file) {
                $path = $file->store('produk', 'public');
                GambarProduk::create([
                    'produk_id' => $produk->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path_gambar' => $path,
                    'gambar_utama' => $maxOrder === 0 && $key === 0, // First image as main if no existing images
                    'urutan' => $maxOrder + $key + 1
                ]);
            }
        }

        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        // Delete all images
        foreach ($produk->gambarProduk as $gambar) {
            Storage::disk('public')->delete($gambar->path_gambar);
            $gambar->delete();
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Delete specific image
     */
    public function deleteImage(GambarProduk $gambar)
    {
        Storage::disk('public')->delete($gambar->path_gambar);
        $gambar->delete();

        return response()->json(['success' => true]);
    }
}
