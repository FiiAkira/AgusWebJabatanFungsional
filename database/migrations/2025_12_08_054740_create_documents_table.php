<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        // Foreign Key ke tabel Users (pastikan tabel users sudah ada/bawaan laravel)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // Foreign Key ke tabel Categories
        $table->foreignId('category_id')->constrained('document_categories')->onDelete('cascade');
        
        $table->string('title');
        $table->string('file_path'); // Menyimpan nama file
        $table->string('semester')->nullable();
        $table->float('angka_kredit')->default(0);
        $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
