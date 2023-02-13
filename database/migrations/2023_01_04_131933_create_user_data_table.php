<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->string('personal_code')->unique();
            $table->string('email')->unique();
            $table->string('telephone_number')->unique();
            $table->string('country');
            $table->string('address');
            $table->timestamps();
        });
    }
    public function down():void
    {
        Schema::dropIfExists('user_data');
    }
};
