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
        Schema::create('product_variants', function (Blueprint $table) {
    $table->id();
    $table->foreignId('product_id')->constrained()->cascadeOnDelete();

    $table->string('sku')->nullable();
    $table->string('barcode')->nullable();

    // Attributes
    $table->string('color')->nullable();
    $table->string('size')->nullable();   // S, M, L OR 10 inch, 12 inch

    // Pricing
    $table->decimal('price', 10, 2);
    $table->decimal('discounted_price', 10, 2)->nullable();

    // Inventory
    $table->integer('stock_quantity')->default(0);
    $table->boolean('in_stock')->default(true);

    // Optional for 3D / prototype
    $table->string('model_3d_path')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
