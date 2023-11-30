<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0",
 *         title="Navigation Api",
 *         description="Navigation List Api",
 *     )
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
     *     path="/api/addLocation",
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
     *              @OA\Property(property="message", type="string", example="Location added successfully"),
     *              @OA\Property(property="location", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="latitude", type="number"),
     *                  @OA\Property(property="longitude", type="number"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="marker_color", type="string"),
     *                  @OA\Property(property="created_at", type="string"),
     *                  @OA\Property(property="updated_at", type="string")
     *              )
     *         )
     *     )
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
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="name"),
     *              @OA\Property(property="latitude", type="string", example="latitude"),
     *              @OA\Property(property="longitude", type="string", example="longitude"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *         )
     *     )
     * )
     */
    public function locationDetails($id): JsonResponse
    {
        $location = Location::findOrFail($id);

        return response()->json([
            'location' => $location
        ]);
    }
}
