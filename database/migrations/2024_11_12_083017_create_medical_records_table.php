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
        Schema::create('medical_record', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien', 'id')->cascadeOnDelete();
            $table->foreignId('docter_id')->constrained('docter', 'id')->cascadeOnDelete();
            $table->foreignId('ruang_id')->constrained('ruangan', 'id')->cascadeOnDelete();
            $table->bigInteger('obat_id');
            $table->text('keluhan');
            $table->text('diagnosa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_record');
    }
};
