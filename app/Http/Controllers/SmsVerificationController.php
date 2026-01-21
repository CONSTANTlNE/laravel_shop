<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class SmsVerificationController extends Controller
{
    public function storeMobile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|regex:/^5\d{8}$/',
        ]);

        if ($request->headers->has('HX-Request') && $validator->fails()) {
            $errors = $validator->errors()->all();

            return view('frontend.smsverification.change_mobile_htmx', compact('errors'));
        }

        $user = auth('web')->user();

        $random = random_int(1000, 9999);

        $user->mobile = $request->mobile;
        $user->sms_code = $random;
        $user->save();

        // SEND SMS NOTIFICATION

        $text1 = 'ვერიფიკაციის კოდი';
        $text2 = $random;
        //          $text3 = 'https://imageai.test/midjourney';

        $sendsms = $text1."\n\n".$text2."\n\n";

        $url = 'https://api.ubill.dev/v1/sms/send';

        $params = [
            'key' => config('credentials.UBILL_KEY'),
            'brandID' => 2,
            'numbers' => '995'.$request->mobile,
            'text' => $sendsms,
            'stopList' => false,
        ];

        Http::get($url, $params);

        return view('frontend.smsverification.confirm_code_htmx');
    }

    public function changeMobile(Request $request)
    {

        return view('frontend.smsverification.change_mobile_htmx');
    }

    //    public function codeResend(Request $request)
    //    {
    //        $user = auth()->user();
    //        if ($user) {
    //            $random = random_int(1000, 9999);
    //            $user->sms_code = $random;
    //            $user->save();
    //
    //
    //            // SEND SMS NOTIFICATION
    //
    //            $text1 = 'ვერიფიკაციის კოდი';
    //            $text2 = $random;
    // //          $text3 = 'https://imageai.test/midjourney';
    //
    //            $sendsms = $text1 . "\n\n" . $text2 . "\n\n";
    //
    //            $url = 'https://api.ubill.dev/v1/sms/send';
    //
    //            $params = [
    //                'key' => config('apikeys.ubill'),
    //                'brandID' => 2,
    //                'numbers' => '995' . $user->mobile,
    //                'text' => $sendsms,
    //                'stopList' => false,
    //            ];
    //
    //            $response2 = Http::get($url, $params);
    //
    //            if ($response2->status() == 200) {
    //                return back()->with('alert_success', 'ვერიფიკაციის კოდი გამოგზავნილია');
    //            } else {
    //                return $response2->json();
    //            }
    //        }
    //    }

    public function verify(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($request->headers->has('HX-Request') && $validator->fails()) {
            $errors = $validator->errors()->all();

            return view('frontend.smsverification.confirm_code_htmx', compact('errors'));
        }

        $user = auth('web')->user();

        if ($request->code != $user->sms_code) {
            $errors = ['The code does not match.'];

            return view('frontend.smsverification.confirm_code_htmx', compact('errors'));
        } else {

            $user->mobile_verified = 1;
            $user->save();

            //
            //            return response()
            //                ->json(['message' => 'Redirecting...'])
            //                ->header('HX-Trigger', json_encode(['redirect' => route('purchase.test')]));
            return view('frontend.smsverification.verification_success_htmx');
        }
    }
}
