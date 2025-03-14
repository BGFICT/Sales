<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->notNullable();
            $table->string('currency', 10)->notNullable()->default('KSH'); // Define once
            $table->decimal('amount', 10, 2)->notNullable(); // Define once with appropriate data type
            $table->string('channel')->nullable();
            $table->string('status')->default('unverified');
            $table->string('reference')->notNullable();
            $table->string('payment_id')->notNullable()->unique(); // Ensure uniqueness if needed
            $table->string('product_name')->notNullable();
            $table->integer('quantity')->notNullable();
            $table->string('payer_name')->notNullable();
            $table->string('payer_email')->notNullable();
            $table->string('payment_status')->notNullable();
            $table->string('payment_method')->notNullable();

            
            $table->timestamps();

            // Optional: Define foreign key constraints if applicable
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
