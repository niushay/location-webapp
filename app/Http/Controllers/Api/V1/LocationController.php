<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function addLocation()
    {
        return response()->json([
            'message' => 'Location added successfully',
            'location' => null]
            , 201);
    }
}
