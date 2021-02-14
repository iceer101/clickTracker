<?php

namespace App\Http\Controllers;

use App\Models\BadDomain;
use App\Models\Click;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController
{
    public function getClicks(): JsonResponse
    {
        $clicks = Click::all();

        $res = [];
        foreach ($clicks as $click) {
            $res[] = array_values($click->toArray());
        }
        return response()->json(["data" => $res]);
    }

    public function addBadDomain(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:0|max:255'

        ]);
        if ($validator->fails())
            return response()->json(array_merge(["error" => true], $validator->errors()->messages()), 400);

        $name = $request->input('name');
        if (!BadDomain::where('name', $name)->exists())
            (new BadDomain(['name' => $name]))->save();

        return response($name, 201);
    }

    public function getBadDomains(): JsonResponse
    {
        $clicks = BadDomain::all();

        $res = [];
        foreach ($clicks as $click) {
            $res[] = array_values($click->toArray());
        }
        return response()->json(["data" => $res]);
    }

}
