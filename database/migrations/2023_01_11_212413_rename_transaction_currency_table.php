<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::table('transaction_currency', function (Blueprint $table) {
            $table->rename('currency_transactions');
        });
    }

    public function down():void
    {
        Schema::table('currency_transactions', function (Blueprint $table) {
            $table->rename('transaction_currency');
        });
    }
};
