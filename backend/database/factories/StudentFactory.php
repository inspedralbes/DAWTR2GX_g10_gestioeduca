<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;


class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),  // Encriptamos la contraseña
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'current_course' => $this->faker->word, // Ejemplo de valor aleatorio para `current_course`
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
