<?php
/**
 * Script migrasi gambar dari storage/app/public/products/ ke public/images/products/
 * Jalankan: php migrate_images.php
 */

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$srcBase = storage_path('app/public/');
$dstBase = public_path('images/products/');

if (!is_dir($dstBase)) {
    mkdir($dstBase, 0755, true);
    echo "Created directory: $dstBase\n";
}

$images = DB::table('product_images')->get();
$updated = 0;
$skipped = 0;

foreach ($images as $img) {
    // Sudah di format baru
    if (str_starts_with($img->image, 'images/products/')) {
        echo "SKIP (already migrated): {$img->image}\n";
        $skipped++;
        continue;
    }

    $srcPath = $srcBase . $img->image;
    if (!file_exists($srcPath)) {
        echo "SKIP (source not found): {$img->image}\n";
        $skipped++;
        continue;
    }

    // Generate nama baru
    $ext      = pathinfo($img->image, PATHINFO_EXTENSION);
    $filename = Str::random(40) . '.' . $ext;
    $dstPath  = $dstBase . $filename;
    $newPath  = 'images/products/' . $filename;

    if (copy($srcPath, $dstPath)) {
        DB::table('product_images')->where('id', $img->id)->update(['image' => $newPath]);
        echo "OK: {$img->image} -> {$newPath}\n";
        $updated++;
    } else {
        echo "FAIL: could not copy {$srcPath}\n";
    }
}

echo "\nDone! Updated: $updated, Skipped: $skipped\n";
