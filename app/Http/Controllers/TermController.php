<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Setting;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{

    public function __construct()
    {
        // Initialize the variable once for all methods
        $this->locales = Language::all();
        $this->mainLocale = Language::where('main', 1)->first();
        $this->settings = Setting::first();
    }
    public function index(){

         $terms = Term::first();

         return view('backend.admin_terms', compact('terms'));
    }

    public function store(Request $request)
    {
        // Validate main locale
        $request->validate([
            'terms'.$this->mainLocale->abbr => 'required|string|max:50000',
        ]);

        // Validate other locales
        foreach ($this->locales as $locale) {
            if ($locale->main !== 1) {
                $request->validate([
                    'terms'.$locale->abbr => 'nullable|string|max:50000',
                ]);
            }
        }

        // Collect translations
        $translations = [];
        foreach ($this->locales as $locale) {
            $abbr = $locale->abbr;
            $translations[$abbr] = $request->input('terms'.$abbr);
        }

        // Update if exists, otherwise create
        $term = Term::firstOrNew(['id' => 1]);

        foreach ($this->locales as $locale) {
            $abbr = $locale->abbr;
            $term->setTranslation('text', $abbr, $request->input('terms'.$abbr));
        }

        $term->save();

        return redirect()->back()->with('alert_success', 'Terms saved successfully.');
    }


    public function update(Request $request){


    }
}
