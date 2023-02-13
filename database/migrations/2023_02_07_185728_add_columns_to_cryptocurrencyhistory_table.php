<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up():void
    {
        Schema::table('crypto_transactions', function ($table) {
            $table->string('currency_symbol')->after('amount');
            $table->string('bill')->after('currency_symbol');
        });
    }

    public function down():void
    {
        Schema::table('crypto_transactions', function ($table) {
            $table->dropColumn('currency_symbol');
            $table->dropColumn('bill');
        });
    }
};
