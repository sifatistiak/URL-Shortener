<?php

namespace App\Http\Controllers;

use App\Models\ShortCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'link' => 'required|url'
        ]);

        $input['link'] = $request->link;
        $input['code'] = Str::random(6);

        ShortCode::create($input);

        return response()->json([
            'short_link' => env('APP_URL') . '/' . $input['code'],
            'long_url' => $request->link,
        ]);
    }

    public function shortenLink($code)
    {
        $find = ShortCode::where('code', $code)->first();

        abort_if(!$find,404);
        return redirect($find->link);
    }
}
