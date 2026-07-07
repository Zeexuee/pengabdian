<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = \Illuminate\Http\Request::create('/admin/pages/1', 'PUT', [
    'title' => 'Beranda',
    'slug' => 'home',
    'content_blocks' => [
        [
            'type' => 'widget',
            'content' => 'widget_program'
        ]
    ]
]);

$controller = app()->make(\App\Http\Controllers\Admin\PageController::class);
$page = \App\Models\Page::find(1);
$response = $controller->update($request, $page);

$page->refresh();
var_dump($page->content_blocks);
