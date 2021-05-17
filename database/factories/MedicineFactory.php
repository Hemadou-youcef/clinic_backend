<?php

namespace Database\Factories;

use App\Models\medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = medicine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'scientific_name' => $this->faker->text(10),
            'trade_name' => $this->faker->text(8) . ' ' . $this->faker->text(10),
        ];
    }
}
