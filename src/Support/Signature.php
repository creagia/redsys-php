<?php

namespace Creagia\Redsys\Support;

class Signature
{
    public static function calculateSignature(
        string $encodedParameters,
        string $order,
        string $secretKey,
    ): string {
        $l = ceil(strlen($order) / 8) * 8;
        $key = substr(
            openssl_encrypt(
                $order . str_repeat("\0", $l - strlen($order)),
                'des-ede3-cbc',
                base64_decode($secretKey),
                OPENSSL_RAW_DATA,
                "\0\0\0\0\0\0\0\0"
            ),
            0,
            $l
        );
        $signature = hash_hmac('sha256', $encodedParameters, $key, true);

        return base64_encode($signature);
    }
}
