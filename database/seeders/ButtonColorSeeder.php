<?php

namespace Database\Seeders;

use App\Models\ButtonColor;
use Illuminate\Database\Seeder;

class ButtonColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            'green',
            'red',
            'blue',
            'yellow',
            'orange',
            'mint',
            'magenta',
            'brown',
        ];

        foreach ($colors as $color) {
            ButtonColor::create([
                'color' => $color,
                'is_active' => $color === 'orange',
            ]);
        }
    }
}
