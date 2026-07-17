<?php

use App\Models\WorkProgram;

$programs = WorkProgram::whereNull('slug')->get();
foreach ($programs as $p) {
    $slug = WorkProgram::generateUniqueSlug($p->title, $p->id);
    $p->update(['slug' => $slug]);
    echo "Updated: {$p->id} -> {$slug}\n";
}
echo "Total: " . $programs->count() . " records updated.\n";
