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
        Schema::create('educations', function (Blueprint $table) {
    $table->id();

    $table->string('institution');
    $table->string('degree');
    $table->string('field')->nullable();

    $table->text('description')->nullable();

    $table->string('location')->nullable();

    $table->date('start_date');
    $table->date('end_date')->nullable();

    $table->boolean('current')->default(false);

    $table->string('institution_url')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
