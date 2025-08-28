<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::create([
            'abbr' => 'ka',
            'language' => 'ქართული',
            'active' => 1,
            'main' => 1,
            'icon' => '                                           
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><mask id="a"><circle cx="256" cy="256" r="256" fill="#fff"/></mask><g mask="url(#a)"><path fill="#eee" d="M0 0h224l32 32 32-32h224v224l-32 32 32 32v224H288l-32-32-32 32H0V288l32-32-32-32Z"/><path fill="#d80027" d="M224 0v224H0v64h224v224h64V288h224v-64H288V0h-64zm-96 96v32H96v32h32v32h32v-32h32v-32h-32V96h-32zm224 0v32h-32v32h32v32h32v-32h32v-32h-32V96h-32zM128 320v32H96v32h32v32h32v-32h32v-32h-32v-32h-32zm224 0v32h-32v32h32v32h32v-32h32v-32h-32v-32h-32z"/></g></svg>
'
        ]);

        $fileName = 'ka.json';
        $filePath = base_path('lang/'.$fileName);
        $content = '{}';


        // Check if the file already exists
        if (!file_exists($filePath)) {
            // Write content to the file
            file_put_contents($filePath, $content);
        }


        Language::create([
            'abbr' => 'en',
            'language' => 'English',
            'active' => 1,
            'main' => 0,
            'icon' => '                                           
<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><mask id="a"><circle cx="256" cy="256" r="256" fill="#fff"/></mask><g mask="url(#a)"><path fill="#eee" d="m0 0 8 22-8 23v23l32 54-32 54v32l32 48-32 48v32l32 54-32 54v68l22-8 23 8h23l54-32 54 32h32l48-32 48 32h32l54-32 54 32h68l-8-22 8-23v-23l-32-54 32-54v-32l-32-48 32-48v-32l-32-54 32-54V0l-22 8-23-8h-23l-54 32-54-32h-32l-48 32-48-32h-32l-54 32L68 0H0z"/><path fill="#0052b4" d="M336 0v108L444 0Zm176 68L404 176h108zM0 176h108L0 68ZM68 0l108 108V0Zm108 512V404L68 512ZM0 444l108-108H0Zm512-108H404l108 108Zm-68 176L336 404v108z"/><path fill="#d80027" d="M0 0v45l131 131h45L0 0zm208 0v208H0v96h208v208h96V304h208v-96H304V0h-96zm259 0L336 131v45L512 0h-45zM176 336 0 512h45l131-131v-45zm160 0 176 176v-45L381 336h-45z"/></g></svg>'
        ]);

        $fileName2 = 'en.json';
        $filePath2 = base_path('lang/'.$fileName2);
        $content2 = '{}';

        // Check if the file already exists
        if (!file_exists($filePath2)) {
            // Write content to the file
            file_put_contents($filePath2, $content2);
        }



    }
}
