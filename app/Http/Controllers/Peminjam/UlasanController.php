<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
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
            'rating' => 'required|integer',
            'komentar' => 'required|string',
        ]);

        $ulasan = Ulasan::create([
            'userID' => $request->input('user_id'),
            'bukuID' => $request->input('buku_id'),
            'rating' => $request->input('rating'),
            'ulasan' => $request->input('komentar'),
        ]);

        if ($ulasan) {
            return back()->with(['success' => 'Terimakasih atas ulasanmu ya :3']);
        } else {
            return back()->with(['error' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ulasan $ulasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ulasan $ulasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ulasan $ulasan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ulasan $ulasan)
    {
        //
    }
}
