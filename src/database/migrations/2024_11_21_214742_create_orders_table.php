<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('user_id');
            $table->string('payment_method');
            $table->string('postal_code');
            $table->string('shipping_address');
            $table->string('building_name');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('クレジットカード', 'コンビニ払い')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
