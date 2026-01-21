<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewUserSmsNotificationJob implements ShouldQueue
{
    use Queueable;

    protected $mobiles;

    protected $user;

    public function __construct(array $mobiles, $user)
    {
        $this->mobiles = $mobiles;
        $this->user = $user;
    }

    public function handle(): void
    {

        $numbers = implode(',', $this->mobiles);
        $text1 = 'ახალი მომხმარებელი';
        $text2 = 'Email: '.$this->user->email;
        $text3 = 'Name: '.$this->user->name;

        $sendsms = $text1."\n\n".$text2."\n\n".$text3;

        $url = 'https://api.ubill.dev/v1/sms/send';

        $params = [
            'key' => config('credentials.UBILL_KEY'),
            'brandID' => 2,
            'numbers' => $numbers,
            'text' => $sendsms,
            'stopList' => false,
        ];

        try {
            $response = Http::get($url, $params);

            if (! $response->successful()) {

                Log::channel('ubill')->error('Ubill HTTP error', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

            }

        } catch (\Throwable $th) {
            Log::channel('ubill')->critical('Ubill exception', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            throw $th; // rethrow so queues fail properly
        }

    }
}
