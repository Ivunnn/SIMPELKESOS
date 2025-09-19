<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
    $table->id();
    $table->string('no_kk')->unique();
    $table->string('no_nik_kepala_keluarga')->nullable()->unique();
    $table->string('nama_kepala_keluarga');
    $table->string('alamat')->nullable();
    // Tambahan wilayah
    $table->string('kecamatan')->nullable();
    $table->string('kelurahan')->nullable();
    $table->string('status_kepemilikan_rumah')->nullable();
    // Pilihan disimpan sebagai string
    $table->string('usaha')->nullable();
    $table->integer('jumlah_keluarga')->nullable();
    $table->string('jenis_lantai')->nullable();
    $table->string('jenis_dinding')->nullable();
    $table->string('jenis_atap')->nullable();
    $table->string('sumber_air_minum')->nullable();
    $table->string('daya_listrik')->nullable();
    $table->string('id_meter_pln')->nullable();
    $table->string('bahan_bakar_memasak')->nullable();
    $table->string('fasilitas_bab')->nullable();
    $table->string('jenis_kloset')->nullable();
    $table->string('pembuangan_tinja')->nullable();
    $table->string('asset_bergerak')->nullable();
    $table->string('asset_tidak_bergerak')->nullable();
    $table->string('ternak')->nullable();
    $table->string('pendapatan')->nullable();
    $table->string('foto_rumah')->nullable();
    $table->string('foto_tampak_dalam')->nullable();
    $table->string('foto_kamar_mandi')->nullable();
    $table->string('bansos')->nullable();
    

    // Koordinat rumah
    $table->decimal('longitude', 11, 8)->nullable();
    $table->decimal('latitude', 10, 8)->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
