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
        Schema::create('sparepart_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->constrained('sparepart');
            $table->integer('jumlah');
            $table->string('order_by')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sparepart_masuk');
    }
};
