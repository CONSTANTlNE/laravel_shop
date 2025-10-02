<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Term;
use Illuminate\Http\Request;

class FaqController extends Controller
{

    public function __construct()
    {
        // Initialize the variable once for all methods
        $this->locales = Language::all();
        $this->mainLocale = Language::where('main', 1)->first();
        $this->settings = Setting::first();
    }

    public function index()
    {

        $faqs = Faq::all()->groupBy('subject');

        return view('backend.admin_faqs', compact('faqs'));
    }

    public function store(Request $request)
    {

        // Validate main locale
        $request->validate([
            'question_' . $this->mainLocale->abbr => 'required|string|max:255',
            'answer_' . $this->mainLocale->abbr => 'required|string|max:500',
            'subject_' . $this->mainLocale->abbr => 'nullable|string|max:100',
        ]);

        // Validate other locales
        foreach ($this->locales as $locale) {
            if ($locale->main !== 1) {
                $request->validate([
                    'question_' . $locale->abbr => 'nullable|string|max:255',
                    'answer_' . $locale->abbr => 'nullable|string|max:500',
                    'subject_' . $locale->abbr => 'nullable|string|max:100',
                ]);
            }
        }

        // Create new FAQ entry
        $faq = new Faq();

        // Assign translations
        foreach ($this->locales as $locale) {
            $abbr = $locale->abbr;
            $faq->setTranslation('question', $abbr, $request->input('question_' . $abbr));
            $faq->setTranslation('answer', $abbr, $request->input('answer_' . $abbr));
            $faq->setTranslation('subject', $abbr, $request->input('subject_' . $abbr));
        }

        $faq->save();

        return back()->with('alert_success', 'Faq saved successfully.');

    }

    public function update(Request $request)
    {
        // Validate main locale
        $request->validate([
            'faq_id'=>'required|exists:faqs,id',
            'question_' . $this->mainLocale->abbr => 'required|string|max:255',
            'answer_' . $this->mainLocale->abbr => 'required|string|max:500',
            'subject_' . $this->mainLocale->abbr => 'nullable|string|max:100',
        ]);

        // Validate other locales
        foreach ($this->locales as $locale) {
            if ($locale->main !== 1) {
                $request->validate([
                    'question_' . $locale->abbr => 'nullable|string|max:255',
                    'answer_' . $locale->abbr => 'nullable|string|max:500',
                    'subject_' . $locale->abbr => 'nullable|string|max:100',
                ]);
            }
        }

        // Create new FAQ entry
        $faq = Faq::find($request->input('faq_id'));

        // Assign translations
        foreach ($this->locales as $locale) {
            $abbr = $locale->abbr;
            $faq->setTranslation('question', $abbr, $request->input('question_' . $abbr));
            $faq->setTranslation('answer', $abbr, $request->input('answer_' . $abbr));
            $faq->setTranslation('subject', $abbr, $request->input('subject_' . $abbr));
        }

        $faq->save();

        return back()->with('alert_success', 'Faq updated successfully.');

    }

    public function delete(Request $request)
    {
        $request->validate([
            'faq_id'=>'required|exists:faqs,id',
        ]);
        $faq = Faq::find($request->input('faq_id'));
        $faq->delete();

        return back()->with('alert_success', 'Faq deleted successfully.');

    }
}
