<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = Kategori::all();

        Buku::factory()
            ->count(20)
            ->state(function () use ($kategoris) {
                return [
                    'kategori_id' => $kategoris->random()->id,
                ];
            })
            ->create();
    }
}