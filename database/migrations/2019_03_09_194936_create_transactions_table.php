<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_id');
            $table->string('transaction_type');
            $table->string('amount')->default('0');            
            $table->string('transaction_charges')->default('0');
            $table->string('balance_befor')->default('0');
            $table->string('balance_after')->default('0');
            $table->unsignedBigInteger('teller_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
