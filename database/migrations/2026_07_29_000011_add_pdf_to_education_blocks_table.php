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
        Schema::table('education_blocks', function (Blueprint $table) {
            $table->string('pdf_file')->nullable()->after('video_file');
        });

        // Update ENUM type using raw statement to include 'pdf'
        try {
            DB::statement("ALTER TABLE education_blocks MODIFY COLUMN type ENUM('image', 'video', 'text', 'pdf') NOT NULL");
        } catch (\Exception $e) {
            // Ignore if DB driver does not enforce enum
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_blocks', function (Blueprint $table) {
            $table->dropColumn('pdf_file');
        });
    }
};
