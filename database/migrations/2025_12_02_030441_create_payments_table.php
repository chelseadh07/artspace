<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');

            $table->unsignedBigInteger('order_id');

            $table->decimal('amount', 10, 2)->default(0);
            $table->string('method')->default('manual_whatsapp');

            $table->enum('payment_status', [
                'unpaid',
                'waiting_confirmation',
                'paid'
            ])->default('unpaid');

            $table->string('payment_proof')->nullable();
            $table->timestamp('payment_date')->nullable();

            $table->timestamps();

            // foreign key
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
