<?php

namespace App\Http\Services\Checkout;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Xendit\QRCode;
use Xendit\Xendit;

class CheckoutService
{

    public function __construct()
    {
        Xendit::setApiKey(env('SECRET_API_KEY'));
    }

    public function createQRCode($args)
    {
        $defParams = [
            'external_id' => Uuid::uuid4()->toString(),
            'type' => 'DYNAMIC',
            'callback_url' => config('app.url') . 'transactions/callback',
            'amount' => $args['amount'],
        ];
        $response = QRCode::create($defParams);

        logger($response);
        return $response;
    }

    public function getQRCode($id)
    {
        $response = QRCode::get($id);
        logger($response);
        return $response;
    }

    public function payQrCode($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.xendit.co/qr_codes/$id/payments/simulate");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, env('SECRET_API_KEY') . ':' . '');

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        logger($result);
        return $result;
    }
}
