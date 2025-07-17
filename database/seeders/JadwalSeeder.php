<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Film;
use App\Models\Studio;
use Carbon\Carbon;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = Film::all();
        $studios = Studio::all();

        if ($films->isEmpty() || $studios->isEmpty()) {
            $this->command->warn('Film atau Studio belum tersedia. Jalankan FilmSeeder dan StudioSeeder dulu.');
            return;
        }

        $startDate = Carbon::now()->startOfDay();
        $endDate = $startDate->copy()->addDays(14);

        $showTimes = [
            '10:00', '13:00', '16:00', '19:00', '22:00'
        ];

        $schedules = [];

        // Create schedules for each film in random studios
        foreach ($films as $film) {
            // Each film gets 3-5 showings per day in different studios
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $studioSelection = $studios->random(rand(3, 5));
                
                foreach ($studioSelection as $studio) {
                    $time = $showTimes[array_rand($showTimes)];
                    
                    $schedules[] = [
                        'film_id' => $film->id,
                        'studio_id' => $studio->id,
                        'waktu_tayang' => $date->copy()->setTimeFromTimeString($time),
                        'harga' => $this->getPriceBasedOnStudioType($studio->tipe)
                    ];
                }
            }
        }

        // Insert all schedules
        foreach ($schedules as $schedule) {
            Jadwal::create($schedule);
        }

        $this->command->info('Jadwal berhasil dibuat: ' . count($schedules) . ' penayangan.');
    }

    private function getPriceBasedOnStudioType($type)
    {
        return match($type) {
            'VIP' => 100000,
            'IMAX' => 75000,
            default => 50000,
        };
    }
}