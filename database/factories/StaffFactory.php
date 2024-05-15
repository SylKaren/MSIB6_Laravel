<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Staff;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    protected $model = Staff::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nip' => fake()->name('gender'),
            'name' => fake()->name(),
            'gender' => fake()->randomElement(['L', 'P']),
            'alamat' => fake()->address(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
