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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->char('reference', 12)->unique();
            $table->string('contact', 15);
            $table->decimal('price', 10, 2);
            $table->enum('payType', ['Efectivo', 'Paypal', 'Mercado Pago', 'Stripe'])->default('Efectivo');
            $table->string('state', 100)->nullable();
            $table->dateTime('finished');
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
        Schema::dropIfExists('repairs');
    }
};
