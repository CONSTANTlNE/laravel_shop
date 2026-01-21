<?php

namespace App\Listeners;

use App\Events\OutOfStockEvent;
use App\Mail\OutOfStockProductsMail;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendOutOfStockEmailNotification
{
    use Dispatchable;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OutOfStockEvent $event): void
    {
        Mail::to('gmta.constantine@gmail.com')->send(
            new OutOfStockProductsMail($event->products)
        );
    }
}
