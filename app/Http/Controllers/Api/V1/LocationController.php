<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/**
 * @OA\Schema(
 *     schema="Location",
 *     title="Location",
 *     description="Location model",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="latitude", type="string"),
 *     @OA\Property(property="longitude", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 *     @OA\Property(property="updated_at", type="string"),
 * )
 */
class LocationController extends Controller
{
    /**
     * Add a new location
     *
     * This endpoint allows you to add a new location by providing latitude, longitude, name, and marker color.
     *
     * @OA\Post(
     *     path="/api/add-location",
     *     tags={"Location"},
     *     summary="Add a new location",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="latitude", type="number", example=40.7488170),
     *              @OA\Property(property="longitude", type="number", example=-73.9854280),
     *              @OA\Property(property="name", type="string", example="Sample Location"),
     *              @OA\Property(property="marker_color", type="string", example="#111111")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Location added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Location added successfully"),
     *             @OA\Property(property="location", type="object", ref="#/components/schemas/Location")
     *         )
     *     ),
     *     @OA\Response(
     *         response=442,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object", example={"latitude": {"The latitude field is required."}, "longitude": {"The longitude field is required."}}),
     *         ),
     *     ),
     * )
     *
     * @param LocationRequest $request
     * @return JsonResponse
     */
    public function addLocation(LocationRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $location = Location::create($validated);

        return response()->json([
            'message' => 'Location added successfully',
            'location' => $location
            ], 201);
    }


    /**
     * Get Location Detail
     * @OA\Get (
     *     path="/api/location/{id}",
     *     tags={"Location"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="locations", type="array", @OA\Items(ref="#/components/schemas/Location"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Location not found"),
     *         ),
     *     ),
     * )
     */
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

    /**
     * Get a paginated list of all locations.
     *
     * @OA\Get(
     *     path="/api/locations",
     *     tags={"Location"},
     *     summary="Get all locations with pagination.",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination.",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of items per page.",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="locations", type="array", @OA\Items(ref="#/components/schemas/Location")),
     *             @OA\Property(
     *                 property="pagination",
     *                 type="object",
     *                 @OA\Property(property="total", type="integer", example=20),
     *                 @OA\Property(property="limit", type="integer", example=10),
     *                 @OA\Property(property="currentPage", type="integer", example=1),
     *                 @OA\Property(property="lastPage", type="integer", example=2),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="to", type="integer", example=10),
     *             ),
     *         ),
     *     ),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * Get a list of all locations sorted by distance from a specified point.
     *
     * @OA\Post(
     *     path="/api/sorted-locations",
     *     tags={"Location"},
     *     summary="Get all locations sorted by distance.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="latitude", type="number", format="float", example=40.748817),
     *             @OA\Property(property="longitude", type="number", format="float", example=-73.985428),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="locations", type="array", @OA\Items(ref="#/components/schemas/Location")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=442,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object", example={"latitude": {"The latitude field is required."}, "longitude": {"The longitude field is required."}}),
     *         ),
     *     ),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * Edit a location.
     *
     * This endpoint allows you to edit an existing location by providing the location ID
     * and the fields you want to update, such as latitude, longitude, name, and marker color.
     *
     * @OA\Put(
     *     path="/api/edit-location/{id}",
     *     tags={"Location"},
     *     summary="Edit an existing location",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the location to edit",
     *         @OA\Schema(type="integer", format="int64"),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="latitude", type="number", example=40.7488170),
     *              @OA\Property(property="longitude", type="number", example=-73.9854280),
     *              @OA\Property(property="name", type="string", example="Updated Location"),
     *              @OA\Property(property="marker_color", type="string", example="#222222")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Location updated successfully"),
     *             @OA\Property(property="location", type="object", ref="#/components/schemas/Location")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Location not found"),
     *         ),
     *     ),
     * )
     *
     * @param int $id
     * @param LocationRequest $request
     * @return JsonResponse
     */
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
