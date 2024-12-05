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
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_desc');
            $table->text('description');
            $table->text('add_info')->nullable();
            $table->string('image');
            $table->string('size');
            $table->text('material');
            $table->integer('price');
            $table->integer('compare_price')->nullable();
            $table->string('stock')->default(0);
            $table->tinyInteger('status')->default('1');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->text('subcategory_id')->nullable();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade')->nullable();
            $table->text('color')->nullable();
            $table->tinyInteger('featured')->default('0');
            $table->tinyInteger('hot')->default('0');
            $table->tinyInteger('sale')->default('0');
            $table->string('created_by');
            
            $table->string('meta_title');
            $table->string('meta_key')->nullable();
            $table->text('meta_desc')->nullable();
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
