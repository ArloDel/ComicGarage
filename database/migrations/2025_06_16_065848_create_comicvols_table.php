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
        Schema::create('comicvols', function (Blueprint $table) {
            $table->id();
            $table->integer("volume");
            $table->string("volume_name")->nullable();
            $table->boolean("is_collected");
            $table->foreignId('comic_id')->constrained('comics')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comicvols');
    }
};
