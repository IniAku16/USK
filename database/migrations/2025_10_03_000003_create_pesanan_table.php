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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('idpesanan'); // PK
    
            $table->unsignedBigInteger('idmenu');
            $table->foreign('idmenu')->references('idmenu')->on('menu')->onDelete('cascade');

            $table->unsignedBigInteger('idpelanggan');
            $table->foreign('idpelanggan')->references('idpelanggan')->on('pelanggan')->onDelete('cascade');

            $table->integer('jumlah');

            $table->unsignedBigInteger('iduser');
            $table->foreign('iduser')->references('iduser')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
