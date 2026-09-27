<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akses_log', function (Blueprint $table) {
            $table->id();
            $table->string('nik_dicari', 16)->nullable();
            $table->string('ip_address', 45);
            $table->string('user_agent', 255)->nullable();
            $table->boolean('berhasil')->default(false);
            $table->timestamps();

            $table->index('ip_address');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akses_log');
    }
};