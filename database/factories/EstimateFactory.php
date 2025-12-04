<?php

namespace Database\Factories;

use App\Models\Estimate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estimate>
 */
class EstimateFactory extends Factory
{
    protected $model = Estimate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $created = Carbon::now()->subDays(rand(0, 10));
        $updated = $created->copy()->addDays(rand(1, 3));
        $date = Carbon::now()->subDays(rand(0, 5));
        $expiry = $date->copy()->addDays(rand(10, 30));

        return [
            'bill_estimateid'   => $this->faker->unique()->numberBetween(1000, 9999),
            'bill_creatorid'    => 1, // admin user ID
            'bill_clientid'     => 1, // first client ID
            'bill_categoryid'   => null,
            'estimate_projectid'=> null,
            'bill_date'         => $date,
            'bill_expiry_date'  => $expiry,
            'bill_created'      => $created,
            'bill_updated'      => $updated,
        ];
    }
}
