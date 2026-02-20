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
            'first_name' => $this->Name(),
            'last_name'  => $this->Name(),
            'gender'     => $this->numberBetween(1, 3),
            'email'      => $this->unique()->safeEmail(),
            'tel'        => $this->phoneNumber(),
            'address'    => $this->city() ,
            'building'   => $this->faker->country,
            'detail'     => $this->text(100),
        ];
        DB::table('contacts')->insert($param);
    }

}
