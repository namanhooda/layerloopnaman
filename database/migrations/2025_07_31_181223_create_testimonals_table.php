<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonals', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // image path or filename
            $table->string('designation')->nullable(); // clickable URL
            $table->string('description')->nullable(); // clickable URL
            $table->string('image')->nullable(); // clickable URL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonals');
    }
};
