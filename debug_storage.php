<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Storage;

echo "=== PRODUCT IMAGES IN DB ===\n";
$imgs = \App\Models\ProductImage::all();
foreach ($imgs as $img) {
    $fullPath = storage_path('app/public/' . $img->image);
    $exists = file_exists($fullPath) ? 'EXISTS' : 'MISSING';
    $publicUrl = asset('storage/' . $img->image);
    echo "ID:{$img->id} | product_id:{$img->product_id} | path:{$img->image} | file:{$exists}\n";
    echo "   -> public URL would be: /storage/{$img->image}\n";
    echo "   -> full path: {$fullPath}\n";
}

echo "\n=== FILES IN storage/app/public/products/ ===\n";
$dir = storage_path('app/public/products');
if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files as $f) {
        if ($f !== '.' && $f !== '..') {
            echo "  $f\n";
        }
    }
} else {
    echo "  (folder does not exist)\n";
}

echo "\n=== SYMLINK CHECK ===\n";
$link = public_path('storage');
echo "public/storage exists: " . (file_exists($link) ? 'YES' : 'NO') . "\n";
echo "is symlink: " . (is_link($link) ? 'YES' : 'NO') . "\n";
echo "symlink target: " . (is_link($link) ? readlink($link) : 'N/A') . "\n";

echo "\n=== PRODUCTS TABLE ===\n";
$products = \App\Models\Product::with('images')->get();
foreach ($products as $p) {
    echo "Product ID:{$p->id} name:{$p->name} images_count:{$p->images->count()}\n";
}
