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

test('Get all locations with pagination', function () {
    Location::factory()->count(3)->create();

    $response = $this->get('/api/locations', [
        'limit' => 2,
        'page' => 1,
        'offset' => 1,
    ]);

    $response
        ->assertStatus(200)
        ->assertJsonStructure([
            'locations' => [
                '*' => [
                    'id',
                    'name',
                    'latitude',
                    'longitude',
                    'created_at',
                    'updated_at',
                ],
            ],
            'pagination' => [
                'total',
                'limit',
                'currentPage',
                'lastPage',
                'from',
                'to',
            ],
        ]);
});
