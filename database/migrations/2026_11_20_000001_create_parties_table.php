<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('party_type')->default('other'); // customer, vendor, employee, other
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->nullableMorphs('partyable');
            $table->timestamps();
            $table->index(['party_type', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
