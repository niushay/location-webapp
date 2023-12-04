<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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

    public function locationDetails($id): JsonResponse
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found',
            ], 404);
        }

        return response()->json([
            'success' =>true,
            'location' => $location
        ]);
    }

    public function getAllLocations(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);

        $locations = Location::orderByDesc('created_at')
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'locations' => $locations->items(),
            'pagination' => [
                'total' => $locations->total(),
                'limit' => $locations->perPage(),
                'currentPage' => $locations->currentPage(),
                'lastPage' => $locations->lastPage(),
                'from' => $locations->firstItem(),
                'to' => $locations->lastItem(),
            ],
        ]);
    }

    public function listLocationsSortedByDistance(Request $request): JsonResponse
    {
        $rules = [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],442);
        }

        $userLatitude = $request->latitude;
        $userLongitude = $request->longitude;

        $locations = Location::all();

        $locationsWithDistance = $locations->map(function ($location) use ($userLatitude, $userLongitude) {
            $location->distance = Location::calculateHaversineDistance(
                $userLatitude,
                $userLongitude,
                $location->latitude,
                $location->longitude
            );
            return $location;
        });

        $sortedLocations = $locationsWithDistance->sortBy('distance')->values();

        return response()->json([
            'success' => true,
            'locations' => $sortedLocations
        ]);
    }

    public function editLocation(int $id, Request $request): JsonResponse
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found',
            ], 404);
        }

        $location->update([
            'latitude' => $request->input('latitude', $location->latitude),
            'longitude' => $request->input('longitude', $location->longitude),
            'name' => $request->input('name', $location->name),
            'marker_color' => $request->input('marker_color', $location->marker_color),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Location updated successfully',
            'location' => $location,
        ]);
    }
}
