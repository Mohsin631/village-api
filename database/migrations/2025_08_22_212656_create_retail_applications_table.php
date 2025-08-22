<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('retail_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 191);
            $table->string('email', 191);
            $table->string('phone', 50);

            $table->string('cv_path', 255); // uploaded file path
            $table->string('linkedin_url')->nullable();
            $table->text('cover_letter')->nullable();

            $table->string('lang', 2)->default('en');
            $table->ipAddress('ip')->nullable();
            $table->string('user_agent', 512)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('retail_applications');
    }
};
