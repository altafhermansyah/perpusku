<?php

namespace App\Http\Controllers\Peminjam;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::with('peminjaman')->latest()->paginate(9);
        return view('menu.listbuku', compact('buku'));
    }

    public function iventaris()
    {
        $userId = Auth::id();
        $status = request('status', 'dipinjam');
        $query = Buku::whereHas('peminjaman', function ($query) use ($userId, $status) {
            if ($status !== 'semua') {
                $query->where('user_id', $userId)->where('statusPeminjaman', $status);
            } else {
                $query->where('user_id', $userId);
            }
        });

        $buku = $query->with(['peminjaman', 'ulasan'])->latest()->paginate(9);
        return view('menu.iventaris', compact('buku'));
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
            'user' => 'required',
            'buku' => 'required',
        ]);

        $status = 'proses';
        $buku = Peminjaman::create([
            'user_id' => $request->input('user'),
            'buku_id' => $request->input('buku'),
            'statusPeminjaman' => $status,
        ]);

        if ($buku) {
            return back()->with(['success' => 'Tunggu permintaan kamu di acc admin ya :3']);
        } else {
            return back()->with(['error' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
