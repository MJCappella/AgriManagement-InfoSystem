<?php
function isValidTransactionCode($code)
{
    $pattern = '/^[A-Z]{3}[0-9][A-Z0-9]{6}$/';
    return preg_match($pattern, $code);
}

$codes = ['SGC0EJGRI6', 'SGC3GNOIH5', 'SG18RK4LNI', 'SGC0EJ', 'INVALIDCODE'];

foreach ($codes as $code) {
    if (isValidTransactionCode($code)) {
        echo "$code is a valid transaction code.\n<br/>";
    } else {
        echo "$code is not a valid transaction code.\n<br/>";
    }
}

echo json_encode(['User password' => md5("123456")]).'<br/>';
echo json_encode(['Admin password' => md5("adm!n123")]).'<br/>';
