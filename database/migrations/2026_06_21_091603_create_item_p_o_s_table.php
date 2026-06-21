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
        Schema::create('item_p_o_s', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();

            $table->foreignId('id_jenis_item_po')
                ->constrained('jenis__item__p_o_s');

            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_p_o_s');
    }
};
