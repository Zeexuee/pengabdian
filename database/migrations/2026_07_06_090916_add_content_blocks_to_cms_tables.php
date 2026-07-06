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
        Schema::table('news', function (Blueprint $table) {
            $table->json('content_blocks')->nullable()->after('content');
        });
        Schema::table('educations', function (Blueprint $table) {
            $table->json('content_blocks')->nullable()->after('content');
        });
        Schema::table('work_programs', function (Blueprint $table) {
            $table->json('content_blocks')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('content_blocks');
        });
        Schema::table('educations', function (Blueprint $table) {
            $table->dropColumn('content_blocks');
        });
        Schema::table('work_programs', function (Blueprint $table) {
            $table->dropColumn('content_blocks');
        });
    }
};
