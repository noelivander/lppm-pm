<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $judul = $this->faker->sentence($nbWords = 7, $variableNbWords = true);
        $slug = time()."-".str_replace(" ","-",strtolower($judul));
        return [
            'judul' => $judul,
            'slug' => $slug,
            'isi' => $this->faker->text($maxNbChars = 300),
            'is_shown' => 1
        ];
    }
}
