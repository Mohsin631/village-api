<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();   // e.g. 'contact', 'branding', 'home_page', etc.
            $table->json('value');             // flexible JSON blob
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('site_settings');
    }
};
