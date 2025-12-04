<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['pending', 'in_progress', 'completed'];
        return [
            'project_id' => Project::inRandomOrder()->first()?->id ?? Project::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement($statuses),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
