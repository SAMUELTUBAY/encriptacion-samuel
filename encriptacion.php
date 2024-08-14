<?php

function encode($key, $text)
{
    // Generar un IV (Vector de Inicialización) aleatorio
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    // Encriptar el texto usando AES en modo CBC
    $text_bytes = openssl_encrypt($text, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

    // Codificar el IV y el texto encriptado en Base64 para su transmisión
    $iv_base64 = base64_encode($iv);
    $text_encrypted_base64 = base64_encode($text_bytes);

    return [$iv_base64, $text_encrypted_base64];
}

function decode($key, $iv, $text)
{
    // Decodificar el IV y el texto encriptado desde Base64
    $iv = base64_decode($iv);
    $text = base64_decode($text);

    // Desencriptar el texto usando AES en modo CBC
    $pt = openssl_decrypt($text, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

    return $pt;
}

// Generar una clave aleatoria de 256 bits (32 bytes)
$key = openssl_random_pseudo_bytes(32);

echo "Ingrese un texto: ";
$text = trim(fgets(STDIN));

// Encriptar el texto
list($iv, $text_encoded) = encode($key, $text);

echo "iv: " . $iv . "\n";
echo "Texto encriptado: " . $text_encoded . "\n";

// Desencriptar el texto
$text_decoded = decode($key, $iv, $text_encoded);
echo "Texto desencriptado: " . $text_decoded . "\n";
