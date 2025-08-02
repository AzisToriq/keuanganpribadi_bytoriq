<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom 'receipt' ke tabel 'transactions'.
     *
     * Kolom ini digunakan untuk menyimpan path/file bukti upload transaksi.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('receipt')->nullable()->after('date'); // Simpan nama/path file bukti
        });
    }

    /**
     * Menghapus kolom 'receipt' saat rollback migration.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('receipt');
        });
    }
};
