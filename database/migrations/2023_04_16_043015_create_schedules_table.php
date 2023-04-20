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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_jadwal');
            $table->string('jam_jadwal', 5);
            $table->string('nama_tugas', 50);
            $table->string('warna', 5);
            $table->tinyInteger('jml_petugas');
            $table->text('petugas')->nullable();
            $table->string('status', 5)->default('open');
            $table->string('lokasi', 15)->default('Gereja Paskalis');
            $table->string('app', 15);
            $table->boolean('published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
