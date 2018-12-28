<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index();
            /*The foreign key 'product_id' that is referencing the 'id' from 'products' table, when deleted it should
            also automatically delete all reviews automatically */
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('customer');
            $table->text('review');
            $table->integer('star');

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
        Schema::dropIfExists('reviews');
    }
}
