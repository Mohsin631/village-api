<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->enum('status', ['open','in_progress','resolved'])->default('open')->after('user_agent');
            $table->enum('priority', ['low','medium','high'])->default('medium')->after('status');
            $table->text('admin_note')->nullable()->after('priority');
            $table->timestamp('handled_at')->nullable()->after('admin_note');
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete()->after('handled_at');
        });
    }

    public function down(): void {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('handled_by');
            $table->dropColumn(['status','priority','admin_note','handled_at']);
        });
    }
};
