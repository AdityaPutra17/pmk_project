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
        //
        Schema::table('invoices', function (Blueprint $table) {

            $table->string('kode_transaksi')->nullable();

            $table->enum('jenis_invoice', [
                'standar',
                'dp',
                'cicilan',
                'pelunasan'
            ])->default('standar');

            $table->decimal(
                'persentase_dp',
                5,
                2
            )->nullable();

            $table->decimal(
                'nominal_dp',
                15,
                2
            )->default(0);

            $table->text('catatan')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
