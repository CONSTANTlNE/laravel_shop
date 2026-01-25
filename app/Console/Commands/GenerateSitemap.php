<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the XML sitemap for SEO';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        // 1. Static Pages
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        // 2. Categories
        // We use 'each' or 'chunk' to save memory
        Category::all()->each(function (Category $category) use ($sitemap) {
            $sitemap->add(
                Url::create(route('category.single',['locale'=>app()->getLocale(),'category'=>$category->slug]))
                    ->setLastModificationDate($category->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });

        // 3. Dishes (Products)
        // Using chunk prevents memory issues if you have 10,000+ dishes
        Product::chunk(100, function ($products) use ($sitemap) {
            foreach ($products as $product) {
                $sitemap->add(
                    Url::create(route('product.single',['locale'=>app()->getLocale(),'product'=>$product->slug]))
                        ->setLastModificationDate($product->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.9)
                );
            }
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }
}
