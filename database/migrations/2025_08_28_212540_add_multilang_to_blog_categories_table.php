<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->string('name_en')->after('id')->nullable();
            $table->string('name_ar')->after('name_en')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropColumn(['name_en','name_ar']);
        });
    }
};
