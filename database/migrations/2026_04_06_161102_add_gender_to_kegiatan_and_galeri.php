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
        Schema::table('kegiatan', function (Blueprint $table) {
            if (!Schema::hasColumn('kegiatan', 'gender')) {
                $table->enum('gender', ['putra', 'putri'])->default('putra')->after('id');
            }
        });
        Schema::table('galeri', function (Blueprint $table) {
            if (!Schema::hasColumn('galeri', 'gender')) {
                $table->enum('gender', ['putra', 'putri'])->default('putra')->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatan', function (Blueprint $table) {
            if (Schema::hasColumn('kegiatan', 'gender')) {
                $table->dropColumn('gender');
            }
        });
        Schema::table('galeri', function (Blueprint $table) {
            if (Schema::hasColumn('galeri', 'gender')) {
                $table->dropColumn('gender');
            }
        });
    }
};
