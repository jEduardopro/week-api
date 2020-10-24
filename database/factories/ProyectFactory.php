<?php

namespace Database\Factories;

use App\Models\Proyect;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProyectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proyect::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" => User::factory(),
            "name" => $this->faker->name,
            "description" => $this->faker->text,
            "color" => null
        ];
    }
}
