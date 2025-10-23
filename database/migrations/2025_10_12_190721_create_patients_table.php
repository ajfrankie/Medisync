<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('blood_group', 5)->nullable();
            $table->string('marital_status')->nullable();
            $table->string('occupation')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('past_surgeries')->nullable();
            $table->string('past_surgeries_details')->nullable();
            $table->string('emergency_person')->nullable();
            $table->string('preferred_language')->nullable();
            $table->string('emergency_relationship')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
