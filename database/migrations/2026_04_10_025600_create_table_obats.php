<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->uuid('id')->primary(); // 🔥 UUID
            $table->string('nama');
            $table->string('tipe'); // tablet, sirup, dll
            $table->integer('stok')->default(0);
            $table->decimal('harga', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};