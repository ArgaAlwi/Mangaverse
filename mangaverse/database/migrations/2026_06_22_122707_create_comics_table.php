<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('cover')->nullable(); // Disimpan di storage
            $table->text('synopsis');
            
            // Relasi
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->foreignId('publisher_id')->constrained()->onDelete('cascade');
            
            // Detail Komik
            $table->string('isbn')->unique()->nullable();
            $table->year('published_year');
            $table->integer('pages');
            $table->string('language')->default('Indonesia');
            $table->decimal('weight', 8, 2)->comment('Dalam gram');
            
            // Harga & Stok
            $table->decimal('price', 12, 2);
            $table->decimal('discount', 5, 2)->default(0)->comment('Dalam persen');
            $table->integer('stock')->default(0);
            
            // Meta
            $table->decimal('rating', 3, 2)->default(0);
            $table->enum('status', ['Available', 'Out of Stock', 'Pre-order'])->default('Available');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};