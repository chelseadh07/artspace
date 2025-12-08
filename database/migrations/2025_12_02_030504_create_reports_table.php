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
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');

            $table->unsignedBigInteger('reported_user_id');
            $table->unsignedBigInteger('reporter_user_id');
            $table->unsignedBigInteger('order_id')->nullable();

            $table->text('message');
            $table->enum('status', ['open', 'in_review', 'resolved'])->default('open');

            $table->timestamps();

            $table->foreign('reported_user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('reporter_user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('order_id')->on('orders')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
