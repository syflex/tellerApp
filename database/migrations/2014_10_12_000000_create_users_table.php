<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->string('name');
            $table->string('email')->nullable();            
            $table->string('phone')->unique();
            $table->string('avatar')->nullable();
            $table->text('address')->nullable();
            $table->boolean('delivery')->default(true);
            $table->string('nok_name')->nullable();
            $table->string('nok_phone')->nullable();
            $table->text('nok_address')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->string('account_number')->nullable();
            $table->string('wallet')->default('0');
            $table->string('referrer_code')->nullable();
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_sub_admin')->default(false);
            $table->boolean('is_accountant')->default(false);
            $table->boolean('is_manager')->default(false);
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->boolean('is_officer')->default(false);
            $table->unsignedBigInteger('officer_id')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->unsignedBigInteger('registrar_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
