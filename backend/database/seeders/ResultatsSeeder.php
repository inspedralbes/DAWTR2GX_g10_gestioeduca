<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResultatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $form_id = 2;
        $user_id = 1;
        $genero = 'Noi';
        $tutor = 'Alvaro'; 
        $centro = 'Pedralbes';
        $poblacion = 'Barcelona';

        DB::table('resultats')->insert([
            'form_id' => $form_id,
            'user_id' => $user_id,
            'totalAgressivitat' => null,
            'agressivitatFisica' => null,
            'agressivitatVerbal' => null,
            'agressivitatRelacional' => null,
            'totalAgressivitat_SN' => null,
            'agressivitatFisica_SN' => null,
            'agressivitatVerbal_SN' => null,
            'agressivitatRelacional_SN' => null,
            'prosocialitat' => null,
            'prosocialitat_SN' => null,
            'totalVictimitzacio' => null,
            'victimitzacioFisica' => null,
            'victimitzacioVerbal' => null,
            'victimitzacioRelacional' => null,
            'totalVictimitzacio_SN' => null,
            'victimitzacioFisica_SN' => null,
            'victimitzacioVerbal_SN' => null,
            'victimitzacioRelacional_SN' => null,
            'popular_SN' => null,
            'rebutjat_SN' => null,
            'ignorat_SN' => null,
            'controvertit_SN' => null,
            'norma_SN' => null,
            'triesPositives_SN' => null,
            'triesNegatives_SN' => null
        ]);
    }
}
