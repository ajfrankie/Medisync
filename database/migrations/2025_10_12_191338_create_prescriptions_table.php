<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('prescriptions', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('vital_id');
        $table->string('medicine_name')->nullable();
        $table->string('dosage')->nullable();
        $table->string('frequency')->nullable();
        $table->string('duration')->nullable();
        $table->text('instructions')->nullable();
        $table->string('prescription_img_path')->nullable();
        $table->timestamps();

        $table->foreign('vital_id')->references('id')->on('vitals')->cascadeOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
