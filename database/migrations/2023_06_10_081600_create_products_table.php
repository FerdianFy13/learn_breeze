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
            $table->foreignId('category_id');
            $table->string('product_name');
            $table->text('description');
            $table->integer('price');
            $table->enum('available', ['Enabled', 'Disabled']);
            $table->integer('stock');
            $table->string('image', 255)->nullable();
            $table->date('expiration_date');
            $table->integer('weight');
            $table->string('origin_country');
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
