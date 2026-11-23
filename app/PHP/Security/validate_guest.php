<?php require_once __DIR__.'/regex.php'; ?>
<?php

function validateGuestInput($data): bool
{
    if (!is_array($data)) {
        return false;
    }

    // 項目ごとの正規表現と最大文字数
    $r = regex();   //正規表現配列呼び出し自作関数。
    $rules = [
        'Name'     => [$r['Name'], 50],
        'Age'      => [$r['Age'], 3],
        'Sex'      => [$r['Sex'], 10],
        'Address1' => [$r['Address1'], 10],
        'Address2' => [$r['Address2'], 25],
        'Address3' => [$r['Address3'], 50],
        'Tel'      => [$r['Tel'], 13],
        'Mail'     => [$r['Mail'], 50]
    ];

    foreach ($rules as $key => [$reg, $max]) {

        // 未定義・NULL・配列などを拒否
        if (!isset($data[$key]) || !is_string($data[$key])) {
            return false;
        }

        $value = $data[$key];

        // 異常なバイト長・不正UTF-8を拒否
        if (
            strlen($value) > $max * 4 ||
            preg_match('//u', $value) !== 1
        ) {
            return false;
        }

        // 入力文字数
        $length = mb_strlen($value, 'UTF-8');

        if ($length < 1 || $length > $max) {
            return false;
        }

        // タブ・改行・その他の制御文字を拒否
        if (preg_match('/[\x00-\x1F\x7F]/', $value) === 1) {
            return false;
        }

        // 元の正規表現による判定
        if (preg_match($reg, $value) !== 1) {
            return false;
        }
    }

    return true;
}

