<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedInteger('order')->default(0);
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->string('excerpt_en')->nullable();
            $table->string('excerpt_ar')->nullable();
            $table->text('body_en')->nullable();
            $table->text('body_ar')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};