<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('title')->nullable(); // Veteriner Hekim, Op. Dr. ...
            $table->string('specialty')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedSmallInteger('experience_years')->default(0);
            $table->json('focus_areas')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vets');
    }
};
