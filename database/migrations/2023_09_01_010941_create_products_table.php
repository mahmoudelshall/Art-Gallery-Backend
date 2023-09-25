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
            $table->unsignedBigInteger('category_id');  //foreign key
            $table->string('name');
            $table->string('description');
            $table->float('price');
            //  $table->string('stock');
            $table->string('image');
            $table->enum('status',['0','1']);
            $table->integer('stock');
            $table->timestamps();

            // Relations
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade'); 
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
