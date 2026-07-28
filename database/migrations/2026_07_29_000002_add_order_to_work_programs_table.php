<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\WorkProgram;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('work_programs', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('status');
        });

        // Set initial order value based on ID sequence for existing rows
        $items = WorkProgram::orderBy('id', 'asc')->get();
        foreach ($items as $index => $item) {
            $item->update(['order' => $index + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_programs', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
