<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 32);
            $table->string('name', 32)->nullable();
            $table->string('email', 64)->unique();
            $table->string('password', 256);
            $table->boolean('isEmailPublic')->default(false);
            $table->string('picture', 256)->nullable();
            $table->string('bio', 200)->nullable();
            $table->string('color', 7);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
