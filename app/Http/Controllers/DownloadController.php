<?php

namespace App\Http\Controllers;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;


class DownloadController extends Controller
{
    public function download(Request $request, $token)
    {
        $purchase = Purchase::where('download_token', $token)->firstOrFail();
        $magazine = Product::findOrFail($purchase->magazine_id);
            
        if (!$purchase->isValid()) {
            abort(403, 'Link expired');
        }


        $file=$magazine->magazine;
        // Remove the '/storage' from the beginning of the path
        // $filePath = str_replace('/storage/', '', "/storage/photos/1/Products/0a402-image4xxl-3-.jpg");
        
        $filePath = str_replace('/storage/', '', $file);

        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download($filePath);
    }
}
