<?php
// Test file: public/upload_test.php
// Akses langsung: http://127.0.0.1:8000/upload_test.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    echo json_encode([
        'FILES_count' => isset($_FILES['images']) ? count($_FILES['images']['name']) : 0,
        'FILES_raw'   => isset($_FILES['images']) ? array_values($_FILES['images']['name']) : [],
        'FILE_errors' => isset($_FILES['images']) ? array_values($_FILES['images']['error']) : [],
        'POST_keys'   => array_keys($_POST),
    ], JSON_PRETTY_PRINT);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Upload Test</title></head>
<body>
<h3>Test Upload Multiple Gambar (PHP Langsung)</h3>
<form method="POST" enctype="multipart/form-data">
    <p>Pilih beberapa gambar sekaligus (tahan Ctrl untuk pilih banyak):</p>
    <input type="file" name="images[]" multiple accept="image/*">
    <br><br>
    <button type="submit">Kirim</button>
</form>
</body>
</html>
