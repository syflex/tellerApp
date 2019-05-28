<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->unsignedBigInteger('user_id');
            $table->string('token_id');
            $table->string('token_type');
            $table->string('amount')->default('0');
            $table->string('balance_befor')->default('0');
            $table->string('balance_after')->default('0');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('payment_tokens');
    }
}
