<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$page = App\Models\Page::where('slug', 'home')->first();
$page->content_blocks = [['type' => 'widget', 'content' => 'widget_anggota']];
$page->save();

echo "Saved widget to home.";
