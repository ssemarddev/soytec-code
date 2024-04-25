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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code')->unique();
            $table->string('sku', 5);
            $table->string('name', 100)->unique();
            $table->text('description');
            $table->string('image', 70);
            $table->decimal('cost', 10, 2);
            $table->decimal('price', 10, 2);
            $table->decimal('offer', 10, 2)->nullable()->default(null);
            $table->integer('stock')->default(0);
            $table->integer('min')->default(0);
            $table->string('model', 100);
            $table->string('trademark', 50);
            $table->enum('type', ['Físico', 'Digital'])->default('Físico');
            $table->foreignId('category_id')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->enum('state', ['Activo', 'Inactivo'])->default('Activo');
            $table->text('tags');
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
        Schema::dropIfExists('products');
    }
};
