<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('role_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('dob')->nullable();
            $table->string('nic')->nullable()->unique();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('image_path')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
