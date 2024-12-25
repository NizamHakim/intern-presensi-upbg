<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tes', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('slug');
            $table->foreignId('tipe_id')->constrained('tipe_tes')->cascadeOnDelete();
            $table->foreignId('ruangan_id')->constrained('ruangan')->cascadeOnDelete();
            $table->string('nomor');
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->boolean('terlaksana');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tes');
    }
};
