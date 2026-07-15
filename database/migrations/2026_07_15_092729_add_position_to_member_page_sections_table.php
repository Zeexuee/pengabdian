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
        Schema::table('member_page_sections', function (Blueprint $table) {
            // 'above' = tampil di atas daftar anggota, 'below' = di bawah
            $table->string('position')->default('below')->after('order');
        });
    }

    public function down(): void
    {
        Schema::table('member_page_sections', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
