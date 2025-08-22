<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void {
        Schema::create('board_members', function (Blueprint $table) {
            $table->id();
            $table->json('name');        // {"en":"Waleed Muhammed","ar":"وليد محمد"}
            $table->json('position');    // {"en":"Founder and Acting CEO","ar":"المؤسس والرئيس التنفيذي بالإنابة"}
            $table->string('image');     // public URL or Storage::url path
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('board_members');
    }
};
