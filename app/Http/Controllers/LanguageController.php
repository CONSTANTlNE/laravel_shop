<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * @property-read \App\Models\Setting $setting
 */
class LanguageController extends Controller
{
    public function languages()
    {
        $locales = Language::orderBy('position', 'asc')->get()->toArray();

        $languages = Language::orderBy('position', 'asc')->get();

        return view('admin.localization.languages', compact('languages', 'locales'));
    }

    public function createLanguage(Request $request)
    {

        $request->validate([
            'abbr' => 'required|string|max:2',
            'language' => 'required|string',
        ]);

        $locales = Language::all()->toArray();
        // ენის შექმნა ბაზაში
        $lang = new Language;
        $lang->abbr = $request->input('abbr');
        $lang->language = $request->input('language');
        $lang->icon = $request->input('icon');
        $lang->position = count($locales) + 1;

        $lang->save();

        $baselangfile = $locales[0]['abbr'].'.json';
        $baselangpath = base_path('lang/'.$baselangfile);
        $languageCode = $request->input('abbr');
        $fileName = $languageCode.'.json';
        $fullPath = base_path('lang');
        $content = '{}';
        $filePath = $fullPath.DIRECTORY_SEPARATOR.$fileName;

        // როცა ძირითდი ენა არსებობს key გადაიტანოს ახალ ენაში
        if (file_exists($baselangpath)) {

            $content = file_get_contents($baselangpath);
            $existingData = json_decode($content, true);

            $keys = array_keys($existingData);
            $keysWithDefaultValues = array_fill_keys($keys, '');
            $newFilePath = $fullPath.DIRECTORY_SEPARATOR.$fileName;
            $newContent = json_encode($keysWithDefaultValues, JSON_PRETTY_PRINT);

            file_put_contents($newFilePath, $newContent);
        } else {

            file_put_contents($filePath, $content);
        }

        return back()->with('locales', $locales);
    }

    public function deleteLanguage(Request $request)
    {

        $locales = Language::all()->toArray();
        $language = Language::where('id', $request->id)->first();
        $language->delete();

        $fileName = $request->abbr.'.json';
        $filePath = base_path('lang/'.$fileName);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        return back()->with('locales', $locales);
    }

    public function updateLangStatus(Request $request)
    {

        $locales = Language::all()->toArray();
        $language = Language::where('id', $request->id)->first();
        if ($language->active == 1 && $language->main != 1) {
            $language->active = 0;
        } else {
            $language->active = 1;
        }
        $language->update();

        return back()->with('locales', $locales);
    }

    public function setMainLang(Request $request)
    {

        $locales = Language::all()->toArray();

        $language = Language::where('id', $request->id)->first();
        $allLanguages = Language::all();
        foreach ($allLanguages as $lang) {
            $lang->main = 0;
            $lang->update();
        }
        $language->main = 1;
        $language->active = 1;

        $language->update();

        return back()->with('locales', $locales);

    }

    public function addTranslation(Request $request)
    {

        $locales = Language::all()->toArray();

        $main = Language::where('main', 1)->pluck('abbr')->first();
        $jsonData = [];
        foreach ($locales as $locale) {
            $fileName = $locale['abbr'].'.json';
            $filePath = base_path('lang/'.$fileName);

            if (File::exists($filePath)) {
                // Read and decode JSON file
                $jsonData[$locale['abbr']] = json_decode(file_get_contents($filePath), true);
            }
        }

        $keys = array_keys($jsonData['ka']);
        $keyCount = count($keys);

        return view('admin.localization.staticTranslation', compact('locales', 'main', 'jsonData', 'keys', 'keyCount'));
    }

    public function storeStaticTranslations(Request $request)
    {

        $languages = Language::all()->pluck('abbr')->toArray();

        foreach ($languages as $language) {

            $fileName = $language.'.json';
            $filePath = base_path('lang/'.$fileName);

            // Extract data from the request
            $key = $request->key;
            $text = $request->$language;

            // Construct the array with dynamic key and language value
            //            $data = [
            //                $key => $text
            //            ];

            $existingContent = file_get_contents($filePath);
            $existingData = json_decode($existingContent, true);
            if (isset($existingData[$key])) {
                return back()->with('error', 'Key already exists');
            }
            $existingData[$key] = $text;

            $updatedContent = json_encode($existingData, JSON_UNESCAPED_UNICODE);

            // Save the updated content back to the file
            file_put_contents($filePath, $updatedContent);

        }

        return back();
    }

    public function updateStaticTranslation(Request $request)
    {

        //        dd($request->all());
        $locales = Language::all()->toArray();
        $languages = Language::all()->pluck('abbr')->toArray();

        // DELETE LOGIC
        if ($request->delete === 'delete') {

            $keys = $request->key;

            foreach ($languages as $index => $language) {

                $fileName = $language.'.json';
                $filePath = base_path('lang/'.$fileName);

                $content = file_get_contents($filePath);

                // Decode the JSON content into an associative array
                $data = json_decode($content, true);

                // Check if the key exists in the array
                if (isset($data[$keys[$index]])) {

                    unset($data[$keys[$index]]);
                    $newContent = json_encode($data, JSON_UNESCAPED_UNICODE);

                    file_put_contents($filePath, $newContent);

                }
            }
        } else {
            //  UPDATE LOGIC
            $abbr = $request->abbr;
            $keys = $request->key;
            $texts = $request->translation;
            //            dd($abbr);

            foreach ($abbr as $index => $lang) {
                $fileName = $lang.'.json';
                $filePath = base_path('lang/'.$fileName);

                $key = $keys[$index];
                $text = $texts[$index];

                $existingContent = file_get_contents($filePath);
                $existingData = json_decode($existingContent, true);
                $existingData[$key] = $text;

                $updatedContent = json_encode($existingData, JSON_UNESCAPED_UNICODE);

                // Save the updated content back to the file
                file_put_contents($filePath, $updatedContent);
            }

        }

        return back()->with('locales', $locales);
    }

    public function changePosition(Request $request)
    {

        $ids = $request->input('id');
        $positions = $request->input('position');

        foreach ($positions as $index => $position) {
            $language = Language::where('id', $ids[$index])->first();
            $language->position = $position;
            $language->save();
        }
    }
}
