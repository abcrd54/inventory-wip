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
        Schema::create('inquiry', function (Blueprint $table) {
            $table->id();
            $table->decimal('harga', 15, 2)->nullable();
            $table->decimal('ongkir', 15, 2)->nullable();
            $table->decimal('ppn', 15, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->string('nama_customer')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->uuid('id_barang');
            $table->foreign('id_barang')->references('id')->on('unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry');
    }
};
