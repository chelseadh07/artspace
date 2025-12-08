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
        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();

            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->string('expected_duration')->nullable(); // contoh: "3-5 hari"
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};
