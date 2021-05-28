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
            $table->string('order_product_id');
            $table->text('description');
            $table->integer('status');
            $table->unsignedBigInteger('user_addesse_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('price');
            $table->string('id_transaction')->default("");
            $table->string('link_transaction')->default("");
            $table->timestamps();

            $table->foreign('user_addesse_id')
                ->references('id')
                ->on('user_addesses')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
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
