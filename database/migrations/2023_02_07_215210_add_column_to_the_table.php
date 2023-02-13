<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::table('currency_transactions', function ($table) {
            $table->string('senders_name')->after('amount');
        });
    }

    public function down():void
    {
        Schema::table('currency_transactions', function ($table) {
            $table->dropColumn('senders_name');
        });
    }
};
