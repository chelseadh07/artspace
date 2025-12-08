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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');

            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('artist_id');
            $table->unsignedBigInteger('service_id');

            $table->text('description_request')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', ['pending', 'accepted', 'in_progress', 'finished', 'cancelled'])
                ->default('pending');

            $table->timestamps();

            $table->foreign('client_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('artist_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('service_id')->on('services')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
