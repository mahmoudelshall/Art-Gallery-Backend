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
        Schema::create('order__products', function (Blueprint $table) {   
            $table->unsignedBigInteger('order_id');  //foreign key
            $table->unsignedBigInteger('product_id');  //foreign key
            $table->string('description')->nullable();
            $table->float('product_price');
            $table->float('product_subTotal');
            $table->integer('product_quantity');
            $table->timestamps();
            // Relations
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order__products');
    }
};
