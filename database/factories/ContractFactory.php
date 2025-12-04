<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        $created = Carbon::now()->subDays(rand(0, 10));
        $updated = $created->copy()->addDays(rand(1, 3));

        return [
            'contract_id' => $this->faker->unique()->numberBetween(1000, 9999),
            'contract_title' => $this->faker->sentence(3),
            'contract_description' => $this->faker->paragraph(),
            'contract_value' => $this->faker->randomFloat(2, 1000, 100000),
            'contract_start_date' => Carbon::now()->subDays(rand(0, 30)),
            'contract_end_date' => Carbon::now()->addDays(rand(30, 120)),
            'contract_status' => $this->faker->randomElement(['draft', 'active', 'completed', 'cancelled']),
            'contract_clientid' => 1,
            'contract_projectid' => null,
            'contract_creatorid' => 1,
            'contract_created' => $created,
            'contract_updated' => $updated,
        ];
    }
}
