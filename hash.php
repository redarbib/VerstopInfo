<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
    $code = isset($_POST['code']) ? $_POST['code'] : '';


    // Prepare data for encryption (keep as JSON for compatibility)
    $data = json_encode([
        'name' => $name,
        'amount' => $amount,
        'code' => $code
    ]);

    $key = '6043924';
    $key = str_pad($key, 16, '0');
    $iv = openssl_random_pseudo_bytes(16);
    $encrypted = openssl_encrypt($data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    $output = base64_encode($iv . $encrypted);

    // Hash the encrypted data and save to bestandInfo.txt
    $fileHash = hash('sha256', $output);
    $txtFile = __DIR__ . '/bestandInfo.txt';
    file_put_contents($txtFile, $fileHash);

    // Prepare data for encryption (keep as JSON for compatibility)
    $data = json_encode([
        'name' => $name,
        'amount' => $amount,
        'code' => $code
    ]);

    $key = '6043924';
    $key = str_pad($key, 16, '0');
    $iv = openssl_random_pseudo_bytes(16);
    $encrypted = openssl_encrypt($data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    $output = base64_encode($iv . $encrypted);

    echo '<!DOCTYPE html>';
    echo '<html><head><title>Encrypted Data</title>';
    echo '<link rel="stylesheet" href="style.css">';
    echo '</head><body>';
    echo '<div class="container">';
    echo '<h2>Encrypted Data:</h2>';
    echo '<textarea rows="5" cols="60" style="width:100%;margin-bottom:20px;">' . htmlspecialchars($output) . '</textarea>';
    echo '<h3 style="margin-top:30px;">bestandInfo.txt SHA-256 Hash:</h3>';
    echo '<div style="word-break:break-all;background:#f7f7f7;padding:10px 12px;border-radius:6px;font-family:monospace;font-size:14px;">' . htmlspecialchars($fileHash) . '</div>';
    echo '<br><a href="index.html" style="display:inline-block;margin-top:10px;">Back</a>';
    echo '</div>';
    echo '</body></html>';
} else {
    header('Location: index.html');
    exit();
}
?>