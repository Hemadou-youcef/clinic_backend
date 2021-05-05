<?php

namespace Database\Factories;

use App\Models\patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $genders = ['male' , 'female'];
        $bloodTypes = ['A+' , 'A-' , 'B+' , 'B-' , 'AB+' , 'AB-'];
        return [


            'firstname' => $this->faker->firstName('male'),
            'lastname' => $this->faker->lastName(),
            'gender' => $genders[ array_rand( $genders , 1)],
            'birthday' => $this->faker->date(),
            'address' => $this->faker->state(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'bloodType' => $bloodTypes[array_rand($bloodTypes , 1)] ,

        ];
    }
}
