<?php

namespace Database\Factories;

use App\Modules\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            //'category_id'=> $this->faker->numberBetween(1, 3),
            'category_id'=> \App\Models\Category::inRandomOrder()->first()->id,
            'first_name' => $this->faker->firstName(),
            'last_name'  => $this->faker->lastName(),
            'gender'     => $this->faker->numberBetween(1, 3),
            'email'      => $this->faker->unique()->safeEmail(),
            'tel'        => $this->faker->numerify('0##-####-####'),
            'address'    => $this->faker->city() ,
            'building'   => $this->faker->country,
            'detail'     => $this->faker->text(100),
            //'created_at' => $this->faker->dateTimeThisYear(),
            //'updated_at' => $this->faker->dateTimeThisYear(),
        ];

    }

}
