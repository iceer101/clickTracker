<?php


namespace App\Http\Controllers;


use App\Models\BadDomain;
use App\Models\Click;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClickController
{

    public function getClicks(): JsonResponse
    {
        return response()->json(Click::all());
    }

    public function getBadDomains(): JsonResponse
    {
        return response()->json(BadDomain::all());
    }

}
