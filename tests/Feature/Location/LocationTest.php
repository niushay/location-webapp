<?php

use App\Models\Location;
use Illuminate\Support\Facades\Artisan;

test('New location can add', function () {

    $response = $this->post('/api/addLocation', [
        "longitude" => 40.7488170,
        "latitude" => -73.9854280,
        "name" => "Sample Location",
        "marker_color" => "#111111"
    ]);

    $response->assertStatus(201);
});
