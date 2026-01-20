<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloadZipController extends Controller
{public function download(Request $request)
{
    // ✅ Check user login
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to download the file.');
    }

    // ✅ File ka direct path (public folder ke andar)
    $file = public_path('coinflow-woocommerces.zip');

    // ✅ File exist check
    if (!file_exists($file)) {
        return redirect()->back()->with('error', 'File not found.');
    }

    // ✅ Force download
    return response()->download($file, 'coinflow-woocommerces.zip');
}

}
