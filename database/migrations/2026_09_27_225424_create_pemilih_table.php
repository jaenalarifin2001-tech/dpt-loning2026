<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemilih', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('nkk', 16);
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('dusun');
            $table->string('tps', 10);
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();

            $table->index('nama');
            $table->index(['dusun', 'rt', 'rw']);
            $table->index(['tps', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemilih');
    }
};