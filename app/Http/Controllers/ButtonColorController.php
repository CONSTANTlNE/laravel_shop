<?php

namespace App\Http\Controllers;

use App\Models\ButtonColor;
use Illuminate\Http\Request;
use Opcodes\LogViewer\Facades\Cache;

class ButtonColorController extends Controller
{
    public function updateButtonColor(Request $request)
    {

        $new_color = ButtonColor::where('color', $request->color)->first();

        if ($new_color) {
            $new_color->is_active = true;
            $new_color->save();

            $old_color = ButtonColor::where('is_active', true)->first();
            $old_color->is_active = false;
            $old_color->save();

            return back();
        }
        Cache::forget('active_button_color');

        return back()->with('alert_error', __('Color not found!'));

    }
}
