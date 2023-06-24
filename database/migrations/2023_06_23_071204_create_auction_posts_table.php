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
        Schema::create('auction_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('product_name');
            $table->string('image')->nullable();
            $table->bigInteger('open_price');
            $table->decimal('product_weight');
            $table->string('product_quality');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auction_posts');
    }
};
