<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::create('transaction_crypto', function (Blueprint $table) {
            $table->id();
            $table->string('from_account');
            $table->string('to_account');
            $table->string('symbol');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('transaction_crypto');
    }
};
