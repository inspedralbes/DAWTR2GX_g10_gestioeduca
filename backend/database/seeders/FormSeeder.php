<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;

class FormSeeder extends Seeder
{
    public function run()
    {
        Form::create([
            'title' => 'Formulario de prueba',
            'description' => 'Un formulario generado para pruebas.',
        ]);
    }
}
