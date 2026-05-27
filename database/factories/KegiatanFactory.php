<?php

namespace Database\Factories;

use App\Models\Kegiatan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KegiatanFactory extends Factory
{
    protected $model = Kegiatan::class;

    public function definition(): array
    {
        return [
            'title'        => fake()->sentence(4),
            'body'         => fake()->paragraph(),
            'date'         => fake()->date(),
            'gender'       => fake()->randomElement(['putra', 'putri']),
            'is_published' => true,
            'photo'        => null,
        ];
    }
}