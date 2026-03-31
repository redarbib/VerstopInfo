<?php

function encryptData($plaintext, $key) {
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivLength);
    $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $ciphertext);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['txtfile']) && $_FILES['txtfile']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['txtfile']['tmp_name'];
    $fileContents = file_get_contents($fileTmpPath);

    $key = str_pad('6043924', 32, '0');
    $output = encryptData($fileContents, $key);

    $txtFile = __DIR__ . '/bestandInfo.txt';
    file_put_contents($txtFile, $output);

    echo '<!DOCTYPE html>';
    echo '<html><head><title>Encrypted Data</title>';
    echo '<link rel="stylesheet" href="style.css">';
    echo '</head><body>';
    echo '<div class="container">';
    echo '<h2>Encrypted Data:</h2>';
    echo '<textarea rows="5" cols="60" style="width:100%;margin-bottom:20px;">' . $output . '</textarea>';
    echo '<br><a href="index.html" style="display:inline-block;margin-top:10px;">Back</a>';
    echo '</div>';
    echo '</body></html>';
} else {
    header('Location: index.html');
    exit();
}
?>