<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->unique();
            $table->foreignId('contract_type_id')->constrained()->restrictOnDelete();
            $table->foreignId('contract_template_id')->nullable()->constrained('contract_templates')->nullOnDelete();
            $table->unsignedBigInteger('parent_contract_id')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->string('title');
            $table->string('business_unit')->default('3d_printing');
            $table->string('party_type')->default('individual');
            $table->string('party_name');
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 40)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('India');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('territory_type')->nullable();
            $table->json('territory_details')->nullable();
            $table->boolean('is_exclusive')->default(false);
            $table->decimal('payment_amount', 12, 2)->nullable();
            $table->string('payment_type')->nullable();
            $table->text('payment_terms')->nullable();
            $table->longText('description')->nullable();
            $table->longText('scope_of_work')->nullable();
            $table->longText('special_restrictions')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('terminated_at')->nullable();
            $table->text('termination_reason')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamps();
            $table->index(['contract_type_id', 'status']);
            $table->index(['start_date', 'end_date']);
            $table->index(['business_unit', 'status']);
        });
    }
    public function down(): void { Schema::dropIfExists('contracts'); }
};
