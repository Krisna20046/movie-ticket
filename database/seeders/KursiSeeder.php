<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kursi;
use App\Models\Studio;

class KursiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studios = Studio::all();

        if ($studios->isEmpty()) {
            $this->command->warn('Studio belum ada. Jalankan StudioSeeder dulu.');
            return;
        }

        foreach ($studios as $studio) {
            $rows = range('A', 'Z');
            $totalRows = min(ceil($studio->jumlah_kursi / 10), 10);
            $seatsPerRow = ceil($studio->jumlah_kursi / $totalRows);

            for ($row = 0; $row < $totalRows; $row++) {
                for ($col = 1; $col <= $seatsPerRow; $col++) {
                    // Stop if we've created all seats
                    if (($row * $seatsPerRow + $col) > $studio->jumlah_kursi) {
                        break;
                    }

                    Kursi::create([
                        'studio_id' => $studio->id,
                        'kode_kursi' => $rows[$row] . $col,
                        'tipe' => $studio->tipe === 'VIP' ? 'VIP' : ($col <= 3 ? 'Premium' : 'Regular')
                    ]);
                }
            }
        }

        $this->command->info('Kursi berhasil dibuat untuk ' . $studios->count() . ' studio.');
    }
}