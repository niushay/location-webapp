<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LocationController extends Controller
{
    public function addLocation(LocationRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $location = Location::create($validated);

        return response()->json([
            'message' => 'Location added successfully',
            'location' => $location
            ], 201);
    }
}
