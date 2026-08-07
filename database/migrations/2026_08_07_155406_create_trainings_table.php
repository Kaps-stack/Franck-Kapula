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
        Schema::create('trainings', function (Blueprint $table) {
    $table->id();

    $table->string('title');

    $table->string('organization')->nullable();

    $table->text('description')->nullable();

    $table->string('category')->nullable();

    $table->date('start_date')->nullable();

    $table->date('end_date')->nullable();

    $table->integer('duration')->nullable();

    $table->string('location')->nullable();

    $table->string('certificate_file')->nullable();

    $table->string('url')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
