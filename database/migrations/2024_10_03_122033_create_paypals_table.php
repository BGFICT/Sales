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
        Schema::create('paypals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('payment_id');
            $table->float('amount');
            $table->string('currency');
            // $table->text('paypal_order_id');
            // $table->text('token')->nullable();
            // $table->text('PayerID')->nullable();
            // $table->text('payload')->nullable();
            $table->string('status')->default('unverified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paypals');
    }
};
