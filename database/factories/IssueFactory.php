<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Issue>
 */
class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => 2,
            'slug' => Str::slug($this->faker->unique()->word(5)),
            'title' => $this->faker->sentence(1),
            'description' =>$this->faker->text(),
            'email' => $this->faker->unique()->safeEmail,
            'priority' => $this->faker->randomElement(['low', 'high']),
            'due_date' => $this->faker->date,
            'hr_id' => 1,
            'manager_id' => 1,
        ];
    }
}
