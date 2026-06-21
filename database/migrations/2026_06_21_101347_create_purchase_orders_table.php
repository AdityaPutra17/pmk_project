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
        Schema::create('purchase_orders', function (Blueprint $table) {

            $table->id();

            $table->string('po_number')->unique();

            $table->date('po_date');

            $table->foreignId('supplier_id');
            $table->foreignId('customer_id');

            $table->date('delivery_date')->nullable();

            $table->foreignId('top_id')->nullable();

            $table->foreignId('franco_id')->nullable();

            $table->enum('ppn',['Ya','Tidak'])
                ->default('Tidak');

            $table->decimal('subtotal',18,2)->default(0);
            $table->decimal('tax',18,2)->default(0);
            $table->decimal('grand_total',18,2)->default(0);

            $table->text('notes')->nullable();

            $table->enum('status',[
                'Draft',
                'Submitted',
                'Approved',
                'Rejected'
            ])->default('Draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
