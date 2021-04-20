<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubPropertiesProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_properties_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("properties_products_id");
            $table->string("name");
            $table->string("value");
            $table->timestamps();

            $table->foreign('properties_products_id')
                ->references('id')
                ->on('properties_products')
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
        Schema::dropIfExists('sub_properties_products');
    }
}
