<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();
        return view('manage.kategori', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string'
        ]);

        $kategori = Kategori::create([
            'nama' => $request->input('kategori')
        ]);

        if ($kategori) {
            return back()->with(['success' => 'Buku Berhasil Ditambah']);
        } else {
            return back()->with(['error' => 'Buku Gagal Ditambah']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {

        $request->validate([
            'kategori' => 'required|string'
        ]);

        $data = Kategori::findOrFail($id);

        $data->update([
            'nama' => $request->input('kategori'),
        ]);

        return back()->with('success', 'Kategori berhasil diedit!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $data = Kategori::findOrFail($id);

        $data->kategoriBuku()->delete();

        $data->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
