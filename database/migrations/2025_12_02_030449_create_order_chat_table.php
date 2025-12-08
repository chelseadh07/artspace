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
        Schema::create('order_chat', function (Blueprint $table) {
            $table->id('chat_id');

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('sender_id');

            $table->text('message')->nullable();
            $table->string('file_url')->nullable();
            $table->timestamp('timestamp')->useCurrent();

            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('sender_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_chat');
    }
};
