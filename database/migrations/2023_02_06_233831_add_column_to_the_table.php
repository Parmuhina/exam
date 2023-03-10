<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::table('crypto_transactions', function ($table) {
            $table->string('user_id')->after('id');
        });
    }

    public function down():void
    {
        Schema::table('crypto_transactions', function ($table) {
            $table->dropColumn('user_id');
        });
    }
};
