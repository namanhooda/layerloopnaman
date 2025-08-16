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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();                      // productTitle
            $table->string('sku')->nullable();                       // productSku
            $table->string('code')->nullable();                       // productSku
            $table->string('barcode')->nullable();                   // productBarcode
            $table->text('description')->nullable();                 // product description (Quill)
            $table->string('featured_image')->nullable();                // uploaded image
            $table->string('image_path')->nullable();                // uploaded image
            $table->string('variant_option')->nullable();            // like color/size
            $table->integer('stock_quantity')->default(0);           // quantity
            $table->decimal('price', 10, 2)->nullable();             // productPrice
            $table->decimal('discounted_price', 10, 2)->nullable();  // productDiscountedPrice
            $table->boolean('charge_tax')->default(true);           // tax checkbox
            $table->boolean('in_stock')->default(true);             // instock toggle
            $table->string('category')->nullable();                 // selected category
            $table->string('status')->default('Published');         // status-org
            $table->string('tags')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
