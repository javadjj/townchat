<?php

class Distance
{

    public function calculate_dist($latitude1, $longitude1, $latitude2, $longitude2)
    {

        $lat1 = $latitude1;
        $lon1 = $longitude1;
        $lat2 = $latitude2;
        $lon2 = $longitude2;

        $earthRadius = 3958.75;

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $dist = $earthRadius * $c;

        // from miles
        $meterConversion = 1609;
        $geopointDistance = $dist * $meterConversion;

        $geopointDistance = (int) $geopointDistance;

        return $geopointDistance;
    }
}