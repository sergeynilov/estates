<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EstateResource;
use App\Models\Estate;
use Inertia\Inertia;

class EstateController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a vue page container with content of the main page.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Frontend/Estate/Index');
    }

    public function filter()
    {
        $request = request();
        $estates = Estate
            ::getByPriceFrom($request->filter_price_from ?? null)
            ->getByPriceTill($request->filter_price_till ?? null)
            ->getByName($request->filter_name ?? null, true)
            ->getByBedrooms($request->filter_bedrooms ?? null)
            ->getByBathrooms($request->filter_bathrooms ?? null)
            ->getByStoreys($request->filter_storeys ?? null)
            ->getByGarages($request->filter_garages ?? null)
            ->get();

        return response()->json([
            'estates' => EstateResource::collection($estates),
        ], HTTP_RESPONSE_OK);
    }
}
