<?php

namespace Database\Factories;

use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubtaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subtask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "task_id" => Task::factory(),
            "name" => $this->faker->name,
            "description" => $this->faker->text,
            "due_date" => $this->faker->date,
            "responsable_id" => User::factory(),
            "status" => 0
        ];
    }
}
