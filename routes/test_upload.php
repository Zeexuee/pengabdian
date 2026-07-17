<?php
// Test upload multiple files
// Akses via: http://127.0.0.1:8000/test-upload

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test-upload', function () {
    return '<!DOCTYPE html>
<html>
<body>
<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="_token" value="' . csrf_token() . '">
<input type="file" name="images[]" multiple accept="image/*">
<button type="submit">Upload</button>
</form>
</body></html>';
});

Route::post('/test-upload', function (Request $request) {
    $result = [];
    $result['has_file'] = $request->hasFile('images');
    $result['all_files'] = is_array($request->file('images')) ? count($request->file('images')) : 'not array';

    if ($request->hasFile('images')) {
        $files = $request->file('images');
        if (!is_array($files)) $files = [$files];
        foreach ($files as $i => $f) {
            $result['files'][] = [
                'index' => $i,
                'name' => $f->getClientOriginalName(),
                'size' => $f->getSize(),
                'valid' => $f->isValid(),
            ];
        }
    }
    return response()->json($result);
});
