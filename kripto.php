<?php
// Fungsi Enkripsi Caesar Cipher dengan ASCII (Kunci pergeseran = 3)
function encryptCaesar($plainText) {
    $key = 3;
    $cipherText = "";
    $length = strlen($plainText);
    for($i = 0; $i < $length; $i++) {
        $char = $plainText[$i];
        // Menggeser nilai ASCII karakter
        $cipherText .= chr(ord($char) + $key);
    }
    return $cipherText;
}

// Fungsi Deskripsi Caesar Cipher dengan ASCII
function decryptCaesar($cipherText) {
    $key = 3;
    $plainText = "";
    $length = strlen($cipherText);
    for($i = 0; $i < $length; $i++) {
        $char = $cipherText[$i];
        // Mengembalikan nilai ASCII karakter
        $plainText .= chr(ord($char) - $key);
    }
    return $plainText;
}
?>