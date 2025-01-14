<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RespostesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los IDs de usuarios
        $userIds = DB::table('users')->pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->warn('No hay usuarios en la tabla users. El seeder no se ejecutará.');
            return;
        }

        // Datos fijos
        $form_id = 2;
        $user_id = 1;
        $genero = 'Noi';
        $tutor = 'Pedro';
        $centro = 'Pedralbes';
        $poblacion = 'Barcelona';

        // Insertar un solo registro con todos los campos fijos y los IDs aleatorios
        DB::table('respostes')->insert([
            'form_id' => $form_id,
            'user_id' => $user_id,
            'genero' => $genero,
            'tutor' => $tutor,
            'centro' => $centro,
            'poblacion' => $poblacion,
            'soc_POS_1_user_id' => $this->getRandomUserId($userIds),
            'soc_POS_2_user_id' => $this->getRandomUserId($userIds),
            'soc_POS_3_user_id' => $this->getRandomUserId($userIds),
            'soc_NEG_1_user_id' => $this->getRandomUserId($userIds),
            'soc_NEG_2_user_id' => $this->getRandomUserId($userIds),
            'soc_NEG_3_user_id' => $this->getRandomUserId($userIds),
            'ar_i_1_user_id' => $this->getRandomUserId($userIds),
            'ar_i_2_user_id' => $this->getRandomUserId($userIds),
            'ar_i_3_user_id' => $this->getRandomUserId($userIds),
            'pros_1_user_id' => $this->getRandomUserId($userIds),
            'pros_2_user_id' => $this->getRandomUserId($userIds),
            'pros_3_user_id' => $this->getRandomUserId($userIds),
            'af_1_user_id' => $this->getRandomUserId($userIds),
            'af_2_user_id' => $this->getRandomUserId($userIds),
            'af_3_user_id' => $this->getRandomUserId($userIds),
            'ar_d_1_user_id' => $this->getRandomUserId($userIds),
            'ar_d_2_user_id' => $this->getRandomUserId($userIds),
            'ar_d_3_user_id' => $this->getRandomUserId($userIds),
            'pros_2_1_user_id' => $this->getRandomUserId($userIds),
            'pros_2_2_user_id' => $this->getRandomUserId($userIds),
            'pros_2_3_user_id' => $this->getRandomUserId($userIds),
            'av_1_user_id' => $this->getRandomUserId($userIds),
            'av_2_user_id' => $this->getRandomUserId($userIds),
            'av_3_user_id' => $this->getRandomUserId($userIds),
            'vf_1_user_id' => $this->getRandomUserId($userIds),
            'vf_2_user_id' => $this->getRandomUserId($userIds),
            'vf_3_user_id' => $this->getRandomUserId($userIds),
            'vv_1_user_id' => $this->getRandomUserId($userIds),
            'vv_2_user_id' => $this->getRandomUserId($userIds),
            'vv_3_user_id' => $this->getRandomUserId($userIds),
            'vr_1_user_id' => $this->getRandomUserId($userIds),
            'vr_2_user_id' => $this->getRandomUserId($userIds),
            'vr_3_user_id' => $this->getRandomUserId($userIds),
            'amics_1_user_id' => $this->getRandomUserId($userIds),
            'amics_2_user_id' => $this->getRandomUserId($userIds),
            'amics_3_user_id' => $this->getRandomUserId($userIds),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Obtener un ID de usuario aleatorio.
     */
    private function getRandomUserId(array $userIds): int
    {
        return $userIds[array_rand($userIds)];
    }
}
