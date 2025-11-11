<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom id_meja pada tabel pesanan jika belum ada
        if (!Schema::hasColumn('pesanan', 'id_meja')) {
            Schema::table('pesanan', function (Blueprint $table) {
                $table->unsignedInteger('id_meja')->after('jumlah');
            });
        }

        // Buat tabel transaksi jika belum ada
        if (!Schema::hasTable('transaksi')) {
            Schema::create('transaksi', function (Blueprint $table) {
                $table->id('idtransaksi');
                $table->unsignedBigInteger('idpesanan');
                $table->integer('total');
                $table->integer('bayar')->nullable();
                $table->timestamps();

                $table->index('idpesanan');
            });
        }
    }

    public function down(): void
    {
        // Rollback pembuatan tabel transaksi
        if (Schema::hasTable('transaksi')) {
            Schema::drop('transaksi');
        }

        // Tidak otomatis menghapus kolom id_meja agar tidak hilang data
        // Jika perlu, aktifkan berikut:
        // Schema::table('pesanan', function (Blueprint $table) {
        //     $table->dropColumn('id_meja');
        // });
    }
};


