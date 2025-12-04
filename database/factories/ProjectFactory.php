<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['pending', 'in_progress', 'completed', 'on_hold'];
        return [
            'client_id' => Client::inRandomOrder()->first()?->id ?? Client::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement($statuses),
            'start_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+3 months'),
        ];
    }
}
