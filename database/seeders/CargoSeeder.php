<?php

namespace Database\Seeders;

use App\Models\Cargo;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_perusahaan' => 'PT XYZ',
                'no_bl' => 'TJ123926',
                'party' => 102,
                'marking' => 'D1 Merah',
                'cargo' => 'Steel Coil',
                'lokasi' => 'GD/201/202/203/115/',
                'status' => 'proses',
                'created_at' => now()->subDays(15),
            ],
            [
                'nama_perusahaan' => 'PT XYZ',
                'no_bl' => 'TJ223926',
                'party' => 224,
                'marking' => 'Z-113 Hijau',
                'cargo' => 'Steel Coil',
                'lokasi' => 'GD/201/202/203/115/',
                'status' => 'complete',
                'created_at' => now()->subDays(10),
            ],
            [
                'nama_perusahaan' => 'PT Maju Bersama',
                'no_bl' => 'BL-001122',
                'party' => 50,
                'marking' => 'A2 Biru',
                'cargo' => 'Aluminium Sheet',
                'lokasi' => 'GD/301/302/',
                'status' => 'proses',
                'created_at' => now()->subDays(8),
            ],
            [
                'nama_perusahaan' => 'PT Logistik Nusantara',
                'no_bl' => 'BL-334455',
                'party' => 175,
                'marking' => 'K7 Kuning',
                'cargo' => 'Copper Wire',
                'lokasi' => 'GD/105/106/',
                'status' => 'complete',
                'created_at' => now()->subDays(5),
            ],
            [
                'nama_perusahaan' => 'PT Sentosa Jaya',
                'no_bl' => 'SJ-778899',
                'party' => 88,
                'marking' => 'M3 Putih',
                'cargo' => 'Iron Pipe',
                'lokasi' => 'GD/401/402/403/',
                'status' => 'proses',
                'created_at' => now()->subDays(2),
            ],
        ];

        foreach ($data as $item) {
            Cargo::create($item);
        }
    }
}
