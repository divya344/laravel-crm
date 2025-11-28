<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        $created = Carbon::now()->subDays(rand(0, 10));
        $updated = $created->copy()->addDays(rand(1, 3));
        $lastContacted = Carbon::now()->subDays(rand(0, 5));

        return [
            'lead_id' => $this->faker->unique()->numberBetween(1000, 9999),
            'lead_firstname' => $this->faker->firstName(),
            'lead_lastname' => $this->faker->lastName(),
            'lead_creatorid' => 1,
            'lead_categoryid' => null,
            'lead_status' => $this->faker->randomElement(['new', 'contacted', 'converted', 'lost']),
            'lead_last_contacted' => $lastContacted,
            'lead_created' => $created,
            'lead_updated' => $updated,
        ];
    }
}
