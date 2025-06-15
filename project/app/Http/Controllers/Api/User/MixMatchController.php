<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Front\FrontBaseController;
use App\Models\Brand;
use App\Models\SchemeEntries;
use Illuminate\Http\Request;

class MixMatchController extends FrontBaseController
{
    public function schemeEntries(Request $request)
    {
        $brand_id = $request->brand_id;

        $brand = Brand::with([
            'scheme',
            'scheme.scheme_entries' => function ($query) {
                $query->orderBy('order');
            },
        ])->where('id', $brand_id)->first();
        if (!$brand) {
            return response()->json(['status'=> 'false','message' => 'Brand not found'], 404);
        }

        return response()->json(['status'=> 'true','data' => $brand]);
    }
        public function fetchSchemeEntry(Request $request)
    {
        $scheme_entry_id = $request->scheme_entry_id;

        $scheme_entry = SchemeEntries::where('id', $scheme_entry_id)->first();
        if (!$scheme_entry) {
            return response()->json(['status'=> 'false','message' => 'Scheme Entry not found'], 404);
        }

        return response()->json(['status'=> 'true','data' => $scheme_entry]);
    }
}

