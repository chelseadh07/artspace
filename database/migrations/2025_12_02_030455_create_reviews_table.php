<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('artist_id');

            $table->integer('rating'); // 1–5
            $table->text('comment')->nullable();

            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('client_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('artist_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
