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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->string('lastName', 60)->default("");
            $table->string('avatar', 60)->nullable()->default(null);
            $table->string('email', 100)->unique();
            $table->string('password')->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('gender', ['Masculino', 'Femenino', 'Otro'])->default('Otro');
            $table->string('phone', 15)->default('');
            $table->string('province', 30)->default('');
            $table->string('city', 30)->default('');
            $table->string('address', 70)->default('');
            $table->enum('state', ['Activa', 'Bloqueada'])->default('Activa');
            $table->rememberToken();
            $table->string('google_id')->nullable()->default(null);
            $table->string('google_token')->nullable()->default(null);
            $table->string('google_refresh_token')->nullable()->default(null);
            $table->string('facebook_id')->nullable()->default(null);
            $table->string('facebook_token')->nullable()->default(null);
            $table->string('facebook_refresh_token')->nullable()->default(null);
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
        Schema::dropIfExists('clients');
    }
};
