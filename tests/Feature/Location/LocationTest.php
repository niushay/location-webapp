<?php

use App\Models\Location;

test('New location can add', function () {

    $locationData = [
        'longitude' => 40.7488170,
        'latitude' => -73.9854280,
        'name' => 'Sample Location',
        'marker_color' => '#111111',
    ];

    $response = $this->post('/api/addLocation', $locationData);

    $response
        ->assertStatus(201)
        ->assertJson([
            'message' => 'Location added successfully',
        ]);

    $location = Location::where($locationData)->first();

    expect($location)->toBeInstanceOf(Location::class);
});

test('Location details can be retrieved', function () {
    $location = Location::factory()->create();

    $response = $this->get("/api/location/{$location->id}");

    $response
        ->assertStatus(200)
        ->assertJson([
            'location' => [
                'id' => $location->id,
            ],
        ]);
});
