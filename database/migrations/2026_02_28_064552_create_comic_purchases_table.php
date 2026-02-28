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
       Schema::create('comic_purchases', function (Blueprint $table) {
        $table->id();
        $table->string('title');          // Judul Komik
        $table->integer('volume');        // Volume ke-berapa
        $table->decimal('price', 10, 2);  // Harga
        $table->date('purchase_date');    // Tanggal beli (untuk tracking bulanan)
        $table->string('store')->nullable(); // Toko tempat beli
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comic_purchases');
    }
};
