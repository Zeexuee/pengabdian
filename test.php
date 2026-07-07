<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$req = new Illuminate\Http\Request();
$req->merge(['title' => 'A', 'content_blocks' => [['type' => 'teks', 'content' => 'hello']]]);
$val = validator($req->all(), ['title' => 'required', 'content_blocks' => 'nullable|array'])->validated();
var_dump($val);
