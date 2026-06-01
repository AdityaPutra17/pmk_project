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
        Schema::create('invoice_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('invoice_id');

            $table->foreignId(
                'delivery_order_detail_id'
            );

            $table->foreignId(
                'sales_order_detail_id'
            );

            $table->integer('qty');

            $table->decimal(
                'harga',
                15,
                2
            );

            $table->decimal(
                'subtotal',
                15,
                2
            );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
