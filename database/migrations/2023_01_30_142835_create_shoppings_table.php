<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piece_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('provider_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('cost', 10, 2);
            $table->timestamps();
        });

        DB::unprepared('DROP TRIGGER IF EXISTS `increment_stock`');
        DB::unprepared('CREATE TRIGGER increment_stock AFTER INSERT ON shoppings
            FOR EACH ROW
            BEGIN
                UPDATE `pieces` SET `stock` = `stock` + NEW.quantity WHERE `id` = NEW.piece_id;
            END
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS `remove_from_stock`');
        DB::unprepared('CREATE TRIGGER remove_from_stock AFTER DELETE ON shoppings
            FOR EACH ROW
            BEGIN
                UPDATE `pieces` SET `stock` = `stock` - OLD.quantity WHERE `id` = OLD.piece_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `increment_stock`');
        DB::unprepared('DROP TRIGGER IF EXISTS `remove_from_stock`');
        Schema::dropIfExists('shoppings');
    }
};
