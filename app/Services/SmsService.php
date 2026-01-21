<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    protected $providers = [
        500 => 'Selfie',
        501 => 'Selfie',
        504 => 'Selfie',
        544 => 'Selfie',
        568 => 'Selfie',
        569 => 'Selfie',
        571 => 'Selfie',
        574 => 'Selfie',
        579 => 'Selfie',
        592 => 'Selfie',
        597 => 'Selfie',

        544 => 'Magti',
        500 => 'Magti',
        511 => 'Magti',
        522 => 'Magti',
        533 => 'Magti',
        505 => 'Magti',
        575 => 'Magti',
        585 => 'Magti',
        550 => 'Magti',
        551 => 'Magti',
        591 => 'Magti',
        595 => 'Magti',
        596 => 'Magti',
        598 => 'Magti',
        599 => 'Magti',

        510 => 'Silknet',
        550 => 'Silknet',
        555 => 'Silknet',
        593 => 'Silknet',
        557 => 'Silknet',
        558 => 'Silknet',
        575 => 'Silknet',
    ];

    public function sendSms($number, $message)
    {
        $text1 = 'გამარჯობა';
        $text2 = 'Midjourney -მ დაასრულა თქვენი მოთხოვნა, გთხოვთ იხილოთ ფოტოები ლინკზე';
        $text3 = 'https://imageai.test/midjourney';

        $sendsms = $text1."\n\n".$text2."\n\n".$text3;

        $url = 'https://api.ubill.dev/v1/sms/send';

        $params = [
            'key' => config('crede.ubill'),
            'brandID' => 2,
            'numbers' => '995551507',
            'text' => $sendsms,
            'stopList' => false,
        ];

        $response2 = Http::get($url, $params);
    }
}
