<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$product = \App\Models\Product::first();
if ($product && $product->images->count() > 0) {
    \App\Models\ProductImage::create([
        'product_id' => $product->id,
        'image' => $product->images->first()->image,
        'order' => 1
    ]);
    echo "Added dummy second image to product {$product->id}\n";
}
