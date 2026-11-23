<?php require_once __DIR__.'/Class_sendMail.php'; ?>
<?php

function sendRecoconMail( string $to, string $subject, string $body ): bool {

    $from = getenv('RECOCON_MAIL_FROM');

    // 送信元の検証（-f オプションに使用するため文字種も制限）
    if (
        !is_string($from) ||
        !preg_match('/\A[A-Za-z0-9._%+\-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}\z/', $from) ||
        !filter_var($from, FILTER_VALIDATE_EMAIL)
    ) {
        return false;
    }

    // 宛先の検証（単一アドレスのみ許可）
    if (
        strlen($to) > 254 ||
        !filter_var($to, FILTER_VALIDATE_EMAIL) ||
        strpbrk($to, "\r\n\0,<>") !== false
    ) {
        return false;
    }

    // 件名へのヘッダー注入防止
    if (strpbrk($subject, "\r\n\0") !== false) {
        return false;
    }

    $m = new sendMail();

    $m->to = $to;
    $m->subject = $subject;
    $m->message = $body;

    $m->command = '-f' . $from;
    $m->From = mb_encode_mimeheader(
        'Reco.Con.事務局', 'ISO-2022-JP', 'B'
    ) . ' <' . $from . '>';
    $m->Sender = $from;

    return $m->send() === true;
}
?>
