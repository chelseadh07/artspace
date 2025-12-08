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
        Schema::create('artworks', function (Blueprint $table) {
            $table->id('artwork_id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();

            $table->timestamps();

            // FK
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('artworks');
    }
};
