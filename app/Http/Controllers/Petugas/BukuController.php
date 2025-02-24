<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\kategoriBuku;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::with('kategoribuku.kategori')->latest()->paginate(6);
        $kategori = Kategori::all();
        return view('manage.buku', compact('buku', 'kategori'));
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
            'gambar'     => 'required|image|mimes:jpeg,jpg,png|max:5048',
            'judul'     => 'required',
            'penulis'   => 'required',
            'penerbit'    => 'required',
            'tahun'  => 'required',
            'kategori'  => 'array',
            'kategori.*' => 'exists:kategoribuku,id',
        ]);

        // $image->move(public_path('images'), $image->hashName());
        $image = $request->file('gambar');
        $imageName = $image->store('images', 'public');

        // dd($request->all());
        $buku = Buku::create([
            'gambar' => $imageName,
            'judul' => $request->input('judul'),
            'penulis' => $request->input('penulis'),
            'penerbit' => $request->input('penerbit'),
            'tahunTerbit' => $request->input('tahun'),
        ]);

        if ($request->has('kategori')) {
            foreach ($request->kategori as $kategoriId) {
                KategoriBuku::create([
                    'buku_id' => $buku->id,
                    'kategori_id' => $kategoriId,
                ]);
            }
        }

        if ($buku) {
            return back()->with(['success' => 'Buku Berhasil Ditambah']);
        } else {
            return back()->with(['error' => 'Buku Gagal Ditambah']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'gambar'     => 'image|mimes:jpeg,jpg,png|max:5048',
        ]);
        $group = Buku::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($group->gambar) {
                Storage::disk('public')->delete($group->gambar);
            }

            $image = $request->file('gambar');
            $imageName = $image->store('images', 'public');
        } else {
            $imageName = $group->gambar;
        }

        $group->update([
            'gambar' => $imageName,
            'judul' => $request->input('judul'),
            'penulis' => $request->input('penulis'),
            'penerbit' => $request->input('penerbit'),
            'tahunTerbit' => $request->input('tahun'),
        ]);

        if ($request->has('kategori')) {
            $kategoriBaru = $request->kategori;
            $kategoriLama = $group->kategoriBuku->pluck('kategori_id')->toArray();

            $hapusKategori = array_diff($kategoriLama, $kategoriBaru);
            if (!empty($hapusKategori)) {
                $group->kategoriBuku()->whereIn('kategori_id', $hapusKategori)->delete();
            }

            $tambahKategori = array_diff($kategoriBaru, $kategoriLama);
            foreach ($tambahKategori as $kategoriId) {
                $group->kategoriBuku()->create([
                    'kategori_id' => $kategoriId
                ]);
            }
        }

        return back()->with('success', 'Data Buku berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $group = Buku::findOrFail($id);

        $group->kategoriBuku()->delete();
        $group->peminjaman()->delete();
        $group->ulasan()->delete();

        if ($group->gambar) {
            Storage::disk('public')->delete($group->gambar);
        }


        $group->delete();

        return back()->with('success', 'Buku berhasil dihapus!');
    }
}
