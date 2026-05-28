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
        Schema::create('sales_orders', function (Blueprint $table) {

            $table->id();

            $table->string('nomor_so')->unique();

            $table->date('tanggal_so');

            // tahun otomatis dari tanggal
            $table->year('tahun');

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('sales_id')
                ->constrained('sales')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // nomor PO customer
            $table->string('nomor_po')->nullable();

            // request delivery dari customer
            $table->date('delivery_request')->nullable();

            // standard lead time
            $table->integer('std_lead_time')->default(0);

            // subtotal sebelum pajak
            $table->decimal('total_dpp', 18, 2)->default(0);

            // nominal ppn
            $table->decimal('ppn_total', 18, 2)->default(0);

            // total akhir
            $table->decimal('grand_total', 18, 2)->default(0);

            $table->enum('status', [
                'draft',
                'process',
                'done',
                'cancel'
            ])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
