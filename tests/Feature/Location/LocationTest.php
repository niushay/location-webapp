<?php

use App\Models\Location;

test('New location can add', function () {

    $locationData = [
        'longitude' => 40.7488170,
        'latitude' => -73.9854280,
        'name' => 'Sample Location',
        'marker_color' => '#111111',
    ];

    $response = $this->post('/api/add-location', $locationData);

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

test('List locations sorted by distance', function () {
    $locations = Location::factory()->count(3)->create();

    $userLatitude = 40.7488170;
    $userLongitude = -73.9854280;

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

    $response = $this->post('/api/sorted-locations', [
        'latitude' => $userLatitude,
        'longitude' => $userLongitude,
    ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'locations' => $sortedLocations->toArray(),
        ]);
});
