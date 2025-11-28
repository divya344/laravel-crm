<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['draft', 'sent', 'paid', 'overdue'];
        return [
            'project_id' => Project::inRandomOrder()->first()?->id ?? Project::factory(),
            'number' => 'INV-' . $this->faker->unique()->numerify('####'),
            'amount' => $this->faker->randomFloat(2, 1000, 10000),
            'status' => $this->faker->randomElement($statuses),
            'issue_date' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
