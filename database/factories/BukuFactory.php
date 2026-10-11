<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'isbn' => fake()->unique()->numerify('978-602-####-##-#'),
            'judul' => fake()->sentence(fake()->numberBetween(5, 10)),
            'penulis' => fake()->name(),
            'penerbit' => fake()->company(),
            'tahun_terbit' => fake()->numberBetween(2000, 2025),
            'kategori_id' => Kategori::factory(),
            'stok' => fake()->numberBetween(0, 100),
            'sinopsis' => fake()->paragraph(3),
        ];
    }
}