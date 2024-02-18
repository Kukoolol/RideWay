<?php
require "vendor/autoload.php";


$geocoder = new \OpenCage\Geocoder\Geocoder('0d037ba79d3a4957ab36d3bda3f0f2d6');

$address = "100 Larkin Street, San Francisco USA";
$result = $geocoder->geocode($address);


$first = $result['results'][0];
print $first['geometry']['lng'] . ';' . $first['geometry']['lat'] ;
$lng = $first['geometry']['lng'];
$lat = $first['geometry']['lat'];

$result = $geocoder->geocode('6 Rue Massillon, 30020 Nîmes, France', ['language' => 'fr', 'countrycode' => 'fr']);

?>
