<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->string('email', 191);
            $table->string('phone', 32);
            $table->foreignId('inquiry_type_id')->nullable()->constrained('inquiry_types')->nullOnDelete();
            $table->text('message')->nullable();
            $table->string('lang', 2)->default('en'); // en|ar
            $table->ipAddress('ip')->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('contact_messages'); }
};
