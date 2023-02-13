<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('account_number')->unique();
            $table->string('currency_symbol')->default('EUR');
            $table->integer('currency_amount')->default(0);
            $table->string('crypto_symbol')->default('');
            $table->integer('crypto_amount')->default(0);
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('accounts');
    }
};
