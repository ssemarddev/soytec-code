<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('lastName', 50);
            $table->char('avatar', 13);
            $table->string('email', 100)->unique();
            $table->string('username', 40)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 15);
            $table->enum('gender', ['Masculino', 'Femenino', 'Otro']);
            $table->enum('level', ['Administrador', 'Usuario'])->default('Usuario');
            $table->enum('state', ['Activa', 'Bloqueada'])->default('Bloqueada');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
