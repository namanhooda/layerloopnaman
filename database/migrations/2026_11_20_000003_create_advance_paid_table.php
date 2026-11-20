<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('advance_paid', function (Blueprint $table) {
            $table->id();
            $table->string('advance_no')->unique();
            $table->foreignId('party_id')->constrained('parties')->restrictOnDelete();
            $table->date('advance_date');
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('pending');
            $table->string('payment_mode')->nullable();
            $table->string('reference_no')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['status', 'advance_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advance_paid');
    }
};
