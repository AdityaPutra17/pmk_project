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
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();

            $table->string('nomor_invoice');

            $table->date('tanggal_invoice');

            $table->foreignId('delivery_order_id');

            $table->foreignId('customer_id');

            $table->decimal('total_dpp', 15, 2);

            $table->decimal('ppn_total', 15, 2);

            $table->decimal('grand_total', 15, 2);

            $table->string('status')
                ->default('unpaid');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
