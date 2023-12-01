<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['longitude', 'latitude', 'marker_color', 'name'];

    /**
     * Calculate the Haversine distance between two sets of coordinates.
     *
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float|int
     */
    public static function calculateHaversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float|int
    {
        $earthRadius = 6371;

        $dlat = deg2rad($lat2 - $lat1);
        $dlon = deg2rad($lon2 - $lon1);

        $a = sin($dlat / 2) * sin($dlat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dlon / 2) * sin($dlon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
