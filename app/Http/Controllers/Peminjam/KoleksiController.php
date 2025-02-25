<?php

namespace App\Http\Controllers\Peminjam;

use App\Models\Koleksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KoleksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'buku_id' => 'required|exists:buku,id',
        ]);

        $user = Auth::user();
        $buku_id = $request->buku_id;

        $koleksi = Koleksi::where('user_id', $user->id)->where('buku_id', $buku_id)->first();

        if ($koleksi) {
            $koleksi->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Koleksi::create([
                'user_id' => $user->id,
                'buku_id' => $buku_id,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Koleksi $koleksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Koleksi $koleksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Koleksi $koleksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Koleksi $koleksi)
    {
        //
    }
}
