<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resident_id'); // relasi ke residents
            $table->string('nik')->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']); // L = Laki, P = Perempuan
            $table->date('tanggal_lahir')->nullable();
            $table->string('hubungan_keluarga'); // Kepala, Istri, Anak, dll
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
