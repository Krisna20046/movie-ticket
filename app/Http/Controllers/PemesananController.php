<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Tiket;
use App\Models\Jadwal;
use App\Models\Kursi;

class PemesananController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'jadwal_id' => 'required|exists:jadwals,id',
            'kursi_id' => 'required|array',
        ]);

        // Cek apakah kursi sudah dipesan
        $sudah_dipesan = Tiket::where('jadwal_id', $request->jadwal_id)
                            ->whereIn('kursi_id', $request->kursi_id)
                            ->exists();

        if ($sudah_dipesan) {
            return back()->with('error', 'Beberapa kursi sudah dipesan. Silakan pilih ulang.');
        }

        $pemesanan = Pemesanan::create([
            'nama' => $request->nama,
            'email' => $request->email
        ]);

        foreach ($request->kursi_id as $kursiId) {
            Tiket::create([
                'pemesanan_id' => $pemesanan->id,
                'jadwal_id' => $request->jadwal_id,
                'kursi_id' => $kursiId
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil.',
            'data' => [
                'nama' => $pemesanan->nama,
                'email' => $pemesanan->email,
                'booking_id' => $pemesanan->id
            ]
        ]);
    }

    public function pilihKursi($id)
    {
        $jadwal = Jadwal::with(['film', 'studio'])->findOrFail($id);

        // Ambil semua kursi studio ini
        $kursis = Kursi::where('studio_id', $jadwal->studio_id)->get();

        // Ambil ID kursi yang sudah dipesan di jadwal ini
        $terisi = Tiket::where('jadwal_id', $jadwal->id)->pluck('kursi_id')->toArray();

        return view('pilih_kursi', compact('jadwal', 'kursis', 'terisi'));
    }
}
