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
        Schema::create('delivery_orders', function (Blueprint $table) {

            $table->id();

            $table->string('nomor_do')->unique();

            $table->date('tanggal_do');

            $table->foreignId('sales_order_id')
                ->constrained('sales_orders');

            $table->foreignId('customer_id')
                ->constrained('customers');

            $table->string('nomor_po')->nullable();

            $table->text('catatan')->nullable();

            $table->enum('status', [
                'draft',
                'done',
                'cancel'
            ])->default('done');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
};
