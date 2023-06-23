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
        Schema::create('transaction_agencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('partner_id');
            $table->foreignId('auction_post_id');
            $table->string('transaction_number');
            $table->string('image')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('retribution_price');
            $table->bigInteger('bargain_price');
            $table->enum('status', ['Pending ', 'Accepted ', 'Canceled', 'Rejected', 'Completed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_agencies');
    }
};
