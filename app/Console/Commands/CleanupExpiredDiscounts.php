<?php

namespace App\Console\Commands;

use App\Models\Discount;
use Illuminate\Console\Command;

class CleanupExpiredDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discounts:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove expired discounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredDiscounts = Discount::where('valid_till', '<', today())
            ->where('active', true)
            ->get();

        foreach ($expiredDiscounts as $discount) {

            $products = $discount->products;

            foreach ($products as $product) {

                if ($discount->increase_price == true) {
                    $price = $product->price_before_discount;
                    $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
                    $historyEntry = [
                        'id' => $code,
                        'update_date' => now()->toDateString(),
                        'price' => $product->price_before_discount,
                        'user_id' => 'schedule',
                        'discount_id' => '',
                        'discount%' => '',
                        'reason' => 'discount removed',
                    ];
                    // add new history record to old one if exists
                    $history = $product->price_history ?? [];
                    $history[] = $historyEntry;

                    $product->update([
                        'price' => $price,
                        'discount_percentage' => null,
                        'discounted' => false,
                        'discount_id' => null,
                        'price_history' => $history,
                    ]);
                } else {
                    $price = $product->price;

                    $product->update([
                        'price' => $price,
                        'discount_percentage' => null,
                        'discounted' => false,
                        'discount_id' => null,
                    ]);
                }
            }

            $discount->update(['active' => false]);
        }
    }
}
