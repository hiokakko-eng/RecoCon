<?php

function regex(): array
{
    $id =
        '/\A[A-Za-z0-9_]{12,16}\z/';
    $password =
        '/\A[^\x00-\x1F\x7F]{12,128}\z/u';
    $name = 
        '/^[ぁ-んァ-ヶー\x{30a0}-\x{30ff}\x{3040}-\x{309f}\x{3005}-\x{3006}\x{30e0}-\x{9fcf}\s]+$/u';
    $age = 
        '/^[0-9]{1,3}+$/u';
    $sex =
        '/\A(?:男|女)\z/u';
    $address = 
        '/^[0-9a-zA-Zぁ-んァ-ヶー\x{30a0}-\x{30ff}\x{3040}-\x{309f}\x{3005}-\x{3006}\x{30e0}-\x{9fcf}\-\s]+$/u';
    $tel = 
        '/^\d{2,5}-\d{1,4}-\d{4}+$/';
    $mail = 
        '/^[0-9a-zA-Z]{1}[\w.-]{0,}@{1}[0-9a-zA-Z]{1}[\w.-]{0,}\.{1,}[0-9a-zA-Z]{1}[\w.-]{0,}$/';

    return [
        'Id'       => $id,
        'Password' => $password,
        'Name'     => $name,
        'Age'      => $age,
        'Sex'      => $sex,
        'Address1' => $address,
        'Address2' => $address,
        'Address3' => $address,
        'Tel'      => $tel,
        'Mail'     => $mail
    ];
}
?>
