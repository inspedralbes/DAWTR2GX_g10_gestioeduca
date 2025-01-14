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
        Schema::create('respostes_processades', function (Blueprint $table) {
            $table->integer('form_id');
            $table->integer('user_id');

            $table->integer('soc_POS')->nullable();
            $table->integer('soc_NEG')->nullable();
            $table->integer('ar_i')->nullable();
            $table->integer('pros')->nullable();
            $table->integer('af')->nullable();
            $table->integer('ar_d')->nullable();
            $table->integer('pros_2')->nullable();
            $table->integer('av')->nullable();
            $table->integer('vf')->nullable();
            $table->integer('vv')->nullable();
            $table->integer('vr')->nullable();
            $table->integer('amics')->nullable();

            $table->primary(['form_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respostes_processades');
    }
};
