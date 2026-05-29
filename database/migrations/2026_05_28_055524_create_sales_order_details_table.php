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
        Schema::create('sales_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')
                ->constrained('sales_orders')
                ->cascadeOnDelete();

            $table->foreignId('item_id')
                ->constrained('items')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('qty')->unsigned();

            $table->decimal('harga', 18, 2);

            $table->decimal('subtotal', 18, 2);

            $table->decimal('ppn', 18, 2)->default(0); 
            $table->decimal('total_after_ppn', 18, 2)->default(0);

            $table->text('keterangan')->nullable();
            $table->decimal('qty_delivered', 18, 2)
                ->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_details');
    }
};
