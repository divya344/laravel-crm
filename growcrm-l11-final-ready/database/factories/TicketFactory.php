<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_title' => $this->faker->sentence(4),
            'ticket_description' => $this->faker->paragraph(),
            'ticket_status' => $this->faker->randomElement(['open', 'in_progress', 'closed']),
            'ticket_priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'ticket_clientid' => 1,
            'ticket_projectid' => 1,
            'ticket_creatorid' => 1,
            'ticket_created' => now(),
            'ticket_updated' => now(),
        ];
    }
}
