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
        Schema::table('menu', function (Blueprint $table) {
            if (!Schema::hasColumn('menu', 'jenis')) {
                $table->string('jenis', 20)->default('makanan')->after('nama_menu');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu', function (Blueprint $table) {
            if (Schema::hasColumn('menu', 'jenis')) {
                $table->dropColumn('jenis');
            }
        });
    }
};


