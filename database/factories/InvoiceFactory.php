<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $header_image = 'uploads/invoices/default-invoice-header-image.png';
        $discount = fake()->numberBetween(10, 100);
        $subTotal = fake()->numberBetween(100, 100000);
        $total = $subTotal - $discount;
        $paid = fake()->numberBetween(0, $total);
        $due = $total - $paid;

        return [
            'client_id' => fake()->numberBetween(1, 5),
            'header_image' => $header_image,
            'reference_no' => fake()->randomNumber(4),
            'note' => fake()->realText(),
            'payment_note' => fake()->realText(),
            'payment_method' => fake()->randomElement(['cash', 'bkash', 'nagad', 'rocket', 'bank', 'card']),
        ];
    }
}
