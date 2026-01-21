<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //    public function update(Request $request)
    //    {
    //        // Optionally validate something more (like required fields)
    //        $request->validate([
    //            // example:
    //            'site_name' => 'nullable|string|max:255',
    //            'timezone' => 'nullable|string|max:255',
    //        ]);
    //
    //        $settings = Setting::first();
    //
    //        $booleanFields = [
    //            'use_sku',
    //            'use_stock',
    //            'use_transportation',
    //            'show_discounted',
    //            'show_discount_percent',
    //            'show_faq',
    //            'use_categories',
    //            'use_email_notification',
    //            'sms_notification',
    //            'dark_theme',
    //            'use_main_banner'
    //        ];
    //
    //        foreach ($booleanFields as $field) {
    //            $settings->$field = $request->has($field) ? 1 : 0;
    //        }
    //
    //        $settings->save();
    //        $settings->min_order_amount=$request->min_order_amount ? $request->min_order_amount : 0;
    //        $settings->save();
    //
    //        $message = "Settings updated";
    //
    //        return  view('frontend.components.toasts.gnera_successl_toast_htmx', compact('message'));
    //    }

    public function update(Request $request)
    {
        // Optionally validate
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:255',
        ]);

        $settings = Setting::first();

        $booleanFields = [
            'use_sku',
            'use_stock',
            'use_transportation',
            'show_discounted',
            'show_discount_percent',
            'show_faq',
            'use_categories',
            'use_email_notification',
            'sms_notification',
            'dark_theme',
            'use_main_banner',
            'use_sms_verification',
            'show_only_categories_on_main',
        ];

        $shouldRefresh = false;

        foreach ($booleanFields as $field) {
            $newValue = $request->has($field) ? 1 : 0;

            // Detect if this is one of the fields that requires a full refresh
            if (in_array($field, ['dark_theme', 'use_main_banner']) && $newValue != $settings->$field) {
                $shouldRefresh = true;
            }

            $settings->$field = $newValue;
        }

        $settings->min_order_amount = $request->min_order_amount ?? 0;

        $settings->save();

        $message = 'Settings updated';

        // Return with HX-Refresh if needed
        //        return response()
        //            ->view('frontend.components.toasts.gnera_successl_toast_htmx', compact('message'))
        //            ->header('HX-Refresh', $shouldRefresh ? 'true' : 'false');

        return back()->with('alert_success', $message);
    }
}
