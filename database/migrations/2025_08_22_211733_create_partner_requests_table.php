<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('partner_requests', function (Blueprint $table) {
            $table->id();

            $table->string('company_name', 191);
            $table->string('contact_person', 150);
            $table->string('email', 191);
            $table->string('phone', 50);

            $table->string('job_title', 150)->nullable();
            $table->string('bank_name', 191)->nullable();
            $table->string('bank_account', 191)->nullable();
            $table->string('iban', 191)->nullable();
            $table->string('vat_registration_number', 100)->nullable();
            $table->string('swift_code', 50)->nullable();
            $table->string('location', 191)->nullable();
            $table->text('services_summary')->nullable();

            $table->string('lang', 2)->default('en');
            $table->ipAddress('ip')->nullable();
            $table->string('user_agent', 512)->nullable();

            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('partner_requests');
    }
};
