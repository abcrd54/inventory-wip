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
       Schema::create('fkb', function (Blueprint $table) {
            $table->id();
            $table->string('no_faktur')->nullable();
            $table->string('nama')->nullable();
            $table->string('alamat');
            $table->string('no_ktp')->nullable();
            $table->string('merk')->nullable();
            $table->string('tipe')->nullable();
            $table->string('jenis')->nullable();
            $table->string('model')->nullable();
            $table->string('tahun_pembuatan')->nullable();
            $table->string('isi_silinder')->nullable();
            $table->string('warna')->nullable();
            $table->string('no_rangka')->nullable();
            $table->string('no_mesin')->nullable();
            $table->string('bahan_bakar')->nullable();
            $table->string('harga')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fkb');
    }
};
