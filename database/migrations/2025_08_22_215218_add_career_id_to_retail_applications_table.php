<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('retail_applications', function (Blueprint $table) {
            $table->foreignId('career_id')
                ->after('id');
        });
    }
    public function down(): void {
        Schema::table('retail_applications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('career_id');
        });
    }
};
