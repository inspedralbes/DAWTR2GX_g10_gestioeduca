<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('respostes', function (Blueprint $table) {
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('user_id');  // Relación con el usuario que responde
            $table->enum('genero', ['Noi', 'Noia'])->nullable();
            $table->string('tutor')->nullable();
            $table->string('centro')->nullable();
            $table->string('poblacion')->nullable();


            // Cambiar los campos de respuestas específicas para que cada uno esté vinculado a un usuario.
            $table->unsignedBigInteger('soc_POS_1_user_id')->nullable();
            $table->unsignedBigInteger('soc_POS_2_user_id')->nullable();
            $table->unsignedBigInteger('soc_POS_3_user_id')->nullable();
            $table->unsignedBigInteger('soc_NEG_1_user_id')->nullable();
            $table->unsignedBigInteger('soc_NEG_2_user_id')->nullable();
            $table->unsignedBigInteger('soc_NEG_3_user_id')->nullable();
            $table->unsignedBigInteger('ar_i_1_user_id')->nullable();
            $table->unsignedBigInteger('ar_i_2_user_id')->nullable();
            $table->unsignedBigInteger('ar_i_3_user_id')->nullable();
            $table->unsignedBigInteger('pros_1_user_id')->nullable();
            $table->unsignedBigInteger('pros_2_user_id')->nullable();
            $table->unsignedBigInteger('pros_3_user_id')->nullable();
            $table->unsignedBigInteger('af_1_user_id')->nullable();
            $table->unsignedBigInteger('af_2_user_id')->nullable();
            $table->unsignedBigInteger('af_3_user_id')->nullable();
            $table->unsignedBigInteger('ar_d_1_user_id')->nullable();
            $table->unsignedBigInteger('ar_d_2_user_id')->nullable();
            $table->unsignedBigInteger('ar_d_3_user_id')->nullable();
            $table->unsignedBigInteger('pros_2_1_user_id')->nullable();
            $table->unsignedBigInteger('pros_2_2_user_id')->nullable();
            $table->unsignedBigInteger('pros_2_3_user_id')->nullable();
            $table->unsignedBigInteger('av_1_user_id')->nullable();
            $table->unsignedBigInteger('av_2_user_id')->nullable();
            $table->unsignedBigInteger('av_3_user_id')->nullable();
            $table->unsignedBigInteger('vf_1_user_id')->nullable();
            $table->unsignedBigInteger('vf_2_user_id')->nullable();
            $table->unsignedBigInteger('vf_3_user_id')->nullable();
            $table->unsignedBigInteger('vv_1_user_id')->nullable();
            $table->unsignedBigInteger('vv_2_user_id')->nullable();
            $table->unsignedBigInteger('vv_3_user_id')->nullable();
            $table->unsignedBigInteger('vr_1_user_id')->nullable();
            $table->unsignedBigInteger('vr_2_user_id')->nullable();
            $table->unsignedBigInteger('vr_3_user_id')->nullable();
            $table->unsignedBigInteger('amics_1_user_id')->nullable();
            $table->unsignedBigInteger('amics_2_user_id')->nullable();
            $table->unsignedBigInteger('amics_3_user_id')->nullable();

            // Clave primaria compuesta
            $table->primary(['form_id', 'user_id']);

            // Relaciones con claves foráneas
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Relaciones para cada campo específico de usuario
            $table->foreign('soc_POS_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('soc_POS_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('soc_POS_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('soc_NEG_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('soc_NEG_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('soc_NEG_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ar_i_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ar_i_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ar_i_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('pros_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('pros_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('pros_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('af_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('af_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('af_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ar_d_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ar_d_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ar_d_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('pros_2_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('pros_2_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('pros_2_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('av_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('av_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('av_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vf_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vf_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vf_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vv_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vv_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vv_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vr_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vr_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vr_3_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('amics_1_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('amics_2_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('amics_3_user_id')->references('id')->on('users')->onDelete('set null');

            // Agregar las columnas created_at y updated_at automáticamente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respostes');
    }
};
