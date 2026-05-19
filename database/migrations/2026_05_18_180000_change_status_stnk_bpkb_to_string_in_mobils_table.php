<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mobil', function (Blueprint $table) {
            $table->string('status_stnk', 100)->default('Ada')->change();
            $table->string('status_bpkb', 100)->default('Ada')->change();
        });
    }

    public function down(): void
    {
        Schema::table('mobil', function (Blueprint $table) {
            $table->enum('status_stnk', ['Ada', 'Tidak Ada'])->default('Ada')->change();
            $table->enum('status_bpkb', ['Ada', 'Tidak Ada'])->default('Ada')->change();
        });
    }
};
