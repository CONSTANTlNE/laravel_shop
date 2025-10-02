<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductFeatureController extends Controller
{
    protected $locales;

    protected $mainLocale;

    public $settings;

    public function __construct()
    {
        // Initialize the variable once for all methods
        $this->locales = Language::all();
        $this->mainLocale = Language::where('main', 1)->first();
        $this->settings = Setting::first();
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'feature_name_'.$this->mainLocale->abbr => 'required|string|max:255',
            'feature_name_'.$this->mainLocale->abbr => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        $feature = new ProductFeature;
        $feature->product_id = $product->id;

        foreach ($this->locales as $locale) {

            $cleaned = preg_replace('/\s+/', ' ', $request->input('feature_name_'.$locale->abbr));
            $trimmed = trim($cleaned);
            $cleaned_descr = preg_replace('/\s+/', ' ', $request->input('feature_text_'.$locale->abbr));
            $trimmed_descr = trim($cleaned_descr);
            $feature->setTranslation('feature_name', $locale->abbr, $trimmed);
            $feature->setTranslation('feature_text', $locale->abbr, $trimmed_descr);
        }

        $feature->save();

        return back()->with('alert_success', 'Feature created successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'feature_id' => 'required|exists:product_features,id',
            'feature_name_'.$this->mainLocale->abbr => 'required|string|max:255',
            'feature_name_'.$this->mainLocale->abbr => 'required|string|max:255',
        ]);

        $feature = ProductFeature::findOrFail($request->feature_id);

        foreach ($this->locales as $locale) {

            $cleaned = preg_replace('/\s+/', ' ', $request->input('feature_name_'.$locale->abbr));
            $trimmed = trim($cleaned);
            $cleaned_descr = preg_replace('/\s+/', ' ', $request->input('feature_text_'.$locale->abbr));
            $trimmed_descr = trim($cleaned_descr);
            $feature->setTranslation('feature_name', $locale->abbr, $trimmed);
            $feature->setTranslation('feature_text', $locale->abbr, $trimmed_descr);
        }

        $feature->save();

        return back()->with('alert_success', 'Feature created successfully.');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'feature_id' => 'required|exists:product_features,id',
        ]);

        $feature = ProductFeature::findOrFail($request->feature_id);
        $feature->delete();

        return back()->with('alert_success', 'Feature deleted successfully.');
    }
}
