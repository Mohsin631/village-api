<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inquiry_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // general, sales, support...
            $table->json('name');             // {"en":"General", "ar":"عام"}
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('inquiry_types'); }
};
