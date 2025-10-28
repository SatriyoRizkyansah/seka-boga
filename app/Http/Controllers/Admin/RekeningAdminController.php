<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekeningAdmin;
use Illuminate\Http\Request;

class RekeningAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekening = RekeningAdmin::latest()->paginate(10);
        return view('admin.rekening.index', compact('rekening'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rekening.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255|unique:rekening_admin,nomor_rekening',
            'nama_pemilik_rekening' => 'required|string|max:255',
            'jenis_rekening' => 'required|in:utama,cadangan',
            'aktif' => 'boolean',
            'catatan' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['aktif'] = $request->has('aktif');

        RekeningAdmin::create($data);

        return redirect()->route('admin.rekening.index')
                        ->with('success', 'Rekening admin berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RekeningAdmin $rekening)
    {
        return view('admin.rekening.show', compact('rekening'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekeningAdmin $rekening)
    {
        return view('admin.rekening.edit', compact('rekening'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekeningAdmin $rekening)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255|unique:rekening_admin,nomor_rekening,' . $rekening->id,
            'nama_pemilik_rekening' => 'required|string|max:255',
            'jenis_rekening' => 'required|in:utama,cadangan',
            'aktif' => 'boolean',
            'catatan' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['aktif'] = $request->has('aktif');

        $rekening->update($data);

        return redirect()->route('admin.rekening.index')
                        ->with('success', 'Rekening admin berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekeningAdmin $rekening)
    {
        $rekening->delete();

        return redirect()->route('admin.rekening.index')
                        ->with('success', 'Rekening admin berhasil dihapus.');
    }
}
