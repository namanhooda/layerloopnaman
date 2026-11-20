<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contract_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->string('stl_file_name')->nullable();
            $table->string('restriction_type')->default('protected');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('contract_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->string('condition_title');
            $table->longText('condition_description');
            $table->string('condition_type')->default('general');
            $table->boolean('is_mandatory')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('contract_condition_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->string('condition_type')->default('general');
            $table->string('applies_to')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('contract_parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->string('party_role')->default('signatory');
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 40)->nullable();
            $table->text('address')->nullable();
            $table->string('signature_path')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('contract_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->string('document_type')->default('supporting');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();
        });

        Schema::create('contract_notices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->string('notice_number')->unique();
            $table->string('notice_type')->default('infringement');
            $table->string('recipient_name');
            $table->string('recipient_email')->nullable();
            $table->longText('violation_description');
            $table->text('requested_action')->nullable();
            $table->date('notice_date')->nullable();
            $table->date('response_deadline')->nullable();
            $table->longText('response_details')->nullable();
            $table->string('status')->default('draft')->index();
            $table->date('resolution_date')->nullable();
            $table->timestamps();
        });

        Schema::create('contract_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action');
            $table->text('description')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->index(['contract_id', 'created_at']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('contract_activity_logs');
        Schema::dropIfExists('contract_notices');
        Schema::dropIfExists('contract_documents');
        Schema::dropIfExists('contract_parties');
        Schema::dropIfExists('contract_condition_templates');
        Schema::dropIfExists('contract_conditions');
        Schema::dropIfExists('contract_products');
    }
};
