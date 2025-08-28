<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('id');
            $table->string('title_ar')->nullable()->after('title_en');
            $table->string('short_description_en', 255)->nullable()->after('title_ar');
            $table->string('short_description_ar', 255)->nullable()->after('short_description_en');
            $table->longText('long_description_en')->nullable()->after('short_description_ar');
            $table->longText('long_description_ar')->nullable()->after('long_description_en');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn([
                'title_en','title_ar',
                'short_description_en','short_description_ar',
                'long_description_en','long_description_ar'
            ]);
        });
    }
};
