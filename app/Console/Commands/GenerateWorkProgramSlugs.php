<?php

namespace App\Console\Commands;

use App\Models\WorkProgram;
use Illuminate\Console\Command;

class GenerateWorkProgramSlugs extends Command
{
    protected $signature   = 'work-programs:generate-slugs';
    protected $description = 'Generate slugs for existing work programs that have none.';

    public function handle(): void
    {
        $programs = WorkProgram::whereNull('slug')->orWhere('slug', '')->get();

        if ($programs->isEmpty()) {
            $this->info('All work programs already have slugs.');
            return;
        }

        foreach ($programs as $p) {
            $slug = WorkProgram::generateUniqueSlug($p->title, $p->id);
            $p->updateQuietly(['slug' => $slug]);
            $this->line("  {$p->id}: {$p->title} → {$slug}");
        }

        $this->info("Done. {$programs->count()} slug(s) generated.");
    }
}
