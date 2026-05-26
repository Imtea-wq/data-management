<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('no_bl');
            $table->integer('party');
            $table->string('marking');
            $table->string('cargo');
            $table->text('lokasi');
            $table->string('foto')->nullable();
            $table->enum('status', ['proses', 'complete'])->default('proses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
