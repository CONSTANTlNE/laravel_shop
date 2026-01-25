<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatwootController extends Controller
{
    public function webhook(Request $request)
    {

        Log::channel('chatwoot')->info('webhook', ['request' => $request->all()]);
    }
}
