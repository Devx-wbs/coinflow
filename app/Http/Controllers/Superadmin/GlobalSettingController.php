<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalSetting;

class GlobalSettingController extends Controller
{
    public function index()
    {
        $apiKey = GlobalSetting::where('key', 'api_key_nowpayments')->value('value');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-sandbox.nowpayments.io/v1/merchant/coins',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "x-api-key: $apiKey",
                "Authorization: Bearer $apiKey"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $coins = json_decode($response, true);

        // get current saved settings
        $fee = GlobalSetting::where('key', 'transaction_fee')->value('value');
        $savedCoins = GlobalSetting::where('key', 'supported_coins')->value('value');
        $logStatus = GlobalSetting::where('key', 'enable_error_logs')->value('value');
        return view('superadmin.globalsetting.index', compact('coins', 'fee', 'savedCoins', 'apiKey', 'logStatus'));
    }


    // Save or update transaction fee
    public function saveFee(Request $request)
    {
        $request->validate([
            'fee_value' => 'required|numeric|min:0'
        ]);

        GlobalSetting::updateOrCreate(
            ['key' => 'transaction_fee'],
            ['value' => $request->fee_value]
        );

        return response()->json(['success' => true, 'message' => 'Transaction fee updated successfully.']);
    }

    // Save or update supported coins
    public function saveCoins(Request $request)
    {
        $request->validate([
            'coins' => 'required|array'
        ]);

        GlobalSetting::updateOrCreate(
            ['key' => 'supported_coins'],
            ['value' => json_encode($request->coins)]
        );

        return response()->json(['success' => true, 'message' => 'Supported coins updated successfully.']);
    }


    public function updateApiKey(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string|min:10',
        ]);

        GlobalSetting::updateOrCreate(
            ['key' => 'api_key_nowpayments'],
            ['value' => $request->input('api_key')]
        );

        return response()->json(['success' => true, 'message' => 'API key updated successfully!']);
    }


    public function saveLogToggle(Request $request)
    {
        $request->validate([
            'log_status' => 'required|boolean'
        ]);

        GlobalSetting::updateOrCreate(
            ['key' => 'enable_error_logs'],
            ['value' => $request->log_status]
        );

        return response()->json([
            'success' => true,
            'message' => 'Log system updated successfully!'
        ]);
    }
}
