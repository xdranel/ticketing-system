<?php

namespace Database\Factories;

use App\Enums\TicketCategory;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => User::factory(),
            'assigned_to' => null,
            'subject' => $this->faker->sentence(),
            'description' => $this->faker->paragraphs(3, true),
            'category' => $this->faker->randomElement(TicketCategory::cases()),
            'priority' => $this->faker->randomElement(TicketPriority::cases()),
            'status' => TicketStatus::Open,
            'closed_at' => null,
        ];
    }

    /**
     * Indicate that the ticket belongs to a specific customer and optionally assigned to an agent.
     */
    public function forUsers(User $customer, ?User $assignee = null): static
    {
        return $this->state(fn (array $attributes) => [
            'customer_id' => $customer->id,
            'assigned_to' => $assignee?->id,
        ]);
    }
}
