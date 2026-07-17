<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_program_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_program_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['image', 'video', 'text']);
            $table->string('title')->nullable();
            $table->longText('content')->nullable();   // teks panjang
            $table->string('image')->nullable();        // path file gambar
            $table->string('video_url')->nullable();    // URL YouTube
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_program_blocks');
    }
};
