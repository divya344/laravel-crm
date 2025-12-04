<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'payment_reference' => strtoupper($this->faker->bothify('PAY-#####')),
            'payment_amount' => $this->faker->randomFloat(2, 500, 50000),
            'payment_method' => $this->faker->randomElement(['cash', 'bank_transfer', 'credit_card', 'paypal']),
            'payment_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'payment_status' => $this->faker->randomElement(['completed', 'pending', 'failed']),
            'payment_invoiceid' => 1, // link to invoice
            'payment_clientid' => 1,
            'payment_creatorid' => 1,
            'payment_created' => now(),
            'payment_updated' => now(),
        ];
    }
}
