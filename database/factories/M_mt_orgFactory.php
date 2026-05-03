<?php

namespace Database\Factories;

use App\Models\M_mt_org;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<M_mt_org>
 */
class M_mt_orgFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'nama' => fake()->unique()->name(),
            'alamat' => fake()->address(),
            'email' => fake()->unique()->safeEmail(),
            'no_tlp' => fake()->unique()->phoneNumber(),
            'kontak_person' => fake()->name(),
            'image' => ENV('DEFAULT_IMG_ORG'),
            'i_pusat' => '1',
            'tele_grup_id' => NULL,
            'f_status' => '2',
            'create' => NULL,
            'update' => NULL,
        ];
    }
}
