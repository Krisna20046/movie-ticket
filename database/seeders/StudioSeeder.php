<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Studio;

class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studios = [
            ['nama' => 'Studio 1', 'jumlah_kursi' => 50, 'tipe' => 'Regular'],
            ['nama' => 'Studio 2', 'jumlah_kursi' => 60, 'tipe' => 'Regular'],
            ['nama' => 'Studio 3', 'jumlah_kursi' => 40, 'tipe' => 'Regular'],
            ['nama' => 'Studio 4', 'jumlah_kursi' => 70, 'tipe' => 'IMAX'],
            ['nama' => 'Studio 5', 'jumlah_kursi' => 30, 'tipe' => 'VIP'],
            ['nama' => 'Studio 6', 'jumlah_kursi' => 55, 'tipe' => 'Regular'],
            ['nama' => 'Studio 7', 'jumlah_kursi' => 45, 'tipe' => 'Regular'],
            ['nama' => 'Studio 8', 'jumlah_kursi' => 80, 'tipe' => 'IMAX'],
            ['nama' => 'Studio 9', 'jumlah_kursi' => 35, 'tipe' => 'VIP'],
            ['nama' => 'Studio 10', 'jumlah_kursi' => 65, 'tipe' => 'Regular'],
            ['nama' => 'Studio 11', 'jumlah_kursi' => 75, 'tipe' => 'IMAX'],
            ['nama' => 'Studio 12', 'jumlah_kursi' => 25, 'tipe' => 'VIP']
        ];

        foreach ($studios as $studio) {
            Studio::create($studio);
        }
    }
}