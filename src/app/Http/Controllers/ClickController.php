<?php


namespace App\Http\Controllers;


use App\Models\BadDomain;
use App\Models\Click;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClickController
{
    const SUCCESS_CLICK_ROUTE = 'success';
    const ERROR_CLICK_ROUTE = 'error';
    const REDIRECT_ON_ERROR = 'http://google.com';

    private $queryStringParams = ['param1', 'param2'];

    public function processClick(Request $request)
    {
        $data = [];
        $linkData = $this->makeLinkDataArray($request);
        $clickModel = (new Click($linkData))->getClick();

        if (is_null($clickModel)) {
            $clickModel = new Click($linkData);
            $redirectTo = self::SUCCESS_CLICK_ROUTE;
            $clickModel->fill($linkData);
        } else {
            $clickModel->increment('error');
            $redirectTo = self::ERROR_CLICK_ROUTE;
            $data['error'] = 'REDIRECT_EXISTING_CLICK';
        }

        $refererUrl = $this->getReferer($request);
        if ((new BadDomain())->isBadDomain($refererUrl)) {
            $clickModel->bad_domain = 1;
            $clickModel->increment('error');
            $redirectTo = self::ERROR_CLICK_ROUTE;
            $data['error'] = 'BAD_DOMAIN';
        } else {
            $clickModel->bad_domain = 0;
        }

        $clickModel->save();

        return $this->sendResponse($request, [
            "redirectTo" => $redirectTo,
            "params" => ['id' => $clickModel->id],
            "data" => $data
        ]);
    }

    private function makeLinkDataArray(Request $request): array
    {
        $clickDataArray = [
            'ua' => $request->userAgent(),
            'ip' => $request->ip(),
            'ref' => $request->headers->get('referer'),
        ];

        $clickDataArray = array_merge($clickDataArray, $this->extractQueryParams($request));

        return $clickDataArray;
    }

    private function getReferer(Request $request): string
    {
        return $request->headers->get('referer') ?? '';
    }

    private function extractQueryParams(Request $request): array
    {
        $queryParams = [];
        $requestParams = $request->all();
        $requestSameCase = [];
        foreach ($requestParams as $key => $value) {
            $requestSameCase[strtolower($key)] = $value;
        }

        foreach ($this->queryStringParams as $paramName) {
            if (array_key_exists($paramName, $requestSameCase)) {
                $queryParams[$paramName] = $requestSameCase[$paramName];
            }
        }
        return $queryParams;
    }

    private function sendResponse($request, $data)
    {
        if (is_null($data['redirectTo']) || is_null($data['params'])) {
            return response()->json(['error' => true, 'message' => 'Required fields not exist']);
        }

        if ($data['data'] && count($data['data']))
            foreach ($data['data'] as $key => $value)
                $request->session()->flash($key, $value);

        return redirect()->route($data['redirectTo'], $data['params']);
    }

    public function success(Request $request, $id): JsonResponse
    {
        return response()->json(['status' => 'success', 'click' => Click::findOrFail($id)]);
    }

    public function error(Request $request, $id)
    {
        $headers = [];
        $click = Click::findOrFail($id);

        if ($click->bad_domain)
            $headers[] = ["Refresh" => "5;url=" . self::REDIRECT_ON_ERROR];

        $data = $request->session()->get('error');
        response()->json($data)->withHeaders($headers)->send();
    }


}
