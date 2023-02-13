<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::table('transaction_currency', function (Blueprint $table) {
            $table->string('from_account')->after('user_id');
        });
    }

    public function down():void
    {
        Schema::table('transaction_currency', function (Blueprint $table) {
            $table->dropColumn('from_account');
        });
    }
};
