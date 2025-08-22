<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();

            // Localized fields (JSON: {"en": "...", "ar": "..."})
            $table->json('job_title');
            $table->json('department');
            $table->json('location');
            $table->json('type'); // e.g., Full Time

            $table->json('short_description');
            $table->json('long_description');

            $table->string('status', 20)->default('active'); // active|closed|draft
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('careers');
    }
};
