<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journeys', function (Blueprint $table) {
            $table->string('price_en')->nullable()->after('description_ar');
            $table->string('price_ar')->nullable()->after('price_en');
            $table->string('duration_en')->nullable()->after('price_ar');
            $table->string('duration_ar')->nullable()->after('duration_en');
            $table->string('image_path')->nullable()->after('duration_ar');
            $table->json('gallery')->nullable()->after('image_path');
            $table->text('included_en')->nullable()->after('gallery');
            $table->text('included_ar')->nullable()->after('included_en');
            $table->text('excluded_en')->nullable()->after('included_ar');
            $table->text('excluded_ar')->nullable()->after('excluded_en');
        });

        Schema::table('journey_stops', function (Blueprint $table) {
            $table->text('description_en')->nullable()->after('place_id');
            $table->text('description_ar')->nullable()->after('description_en');
            $table->string('image_path')->nullable()->after('description_ar');
        });
    }

    public function down(): void
    {
        Schema::table('journey_stops', function (Blueprint $table) {
            $table->dropColumn(['description_en', 'description_ar', 'image_path']);
        });

        Schema::table('journeys', function (Blueprint $table) {
            $table->dropColumn([
                'price_en', 'price_ar',
                'duration_en', 'duration_ar',
                'image_path', 'gallery',
                'included_en', 'included_ar',
                'excluded_en', 'excluded_ar',
            ]);
        });
    }
};
