<?php

namespace App\Http\Controllers;

use App\Components\PolygonApi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * Get initial data for the app.
     * @param Request $request
     * @param $date
     * @return \Illuminate\Http\JsonResponse
     */
    public function init(Request $request, $date) {
        $currency = config('app.currency');
        $currentDate = Carbon::create($date)->format('Y-m-d');;
        $polygon = new PolygonApi($currentDate);
        $result = $polygon->getCryptoByDay();
        if($result['status'] === 'error') {
            $result['data'] = [
                'crypto' => [],
                'currency' => $currency,
                'current_date' => $currentDate,
            ];
            return response()->json($result);
        }
        $crypto = $polygon->prepareToVisible();
        return response()->json([
            'status'   => 'ok' ,
            'data' => [
                'crypto' => $crypto,
                'currency' => $currency,
                'current_date' => $currentDate,
            ]
        ], 200);
    }

    /**
     * Update data by new date.
     * @param Request $request
     * @param $date
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCrypto(Request $request, $date) {

        $currentDate = Carbon::create($date)->format('Y-m-d');;
        $polygon = new PolygonApi($currentDate);
        $result = $polygon->getCryptoByDay();
        if($result['status'] === 'error') {
            return response()->json($result);
        }
        $crypto = $polygon->prepareToVisible();
        return response()->json([
            'status'   => 'ok' ,
            'data' => [
                'crypto' => $crypto,
            ]
        ], 200);
    }
}
