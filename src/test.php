<?php

require_once './vendor/autoload.php';

// fetch data from the API
$json = file_get_contents("https://geoservices.grand-nancy.org/arcgis/rest/services/public/VOIRIE_Parking/MapServer/0/query?where=1%3D1&text=&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&relationParam=&outFields=nom%2Cadresse%2Cplaces%2Ccapacite&returnGeometry=true&returnTrueCurves=false&maxAllowableOffset=&geometryPrecision=&outSR=4326&returnIdsOnly=false&returnCountOnly=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&returnZ=false&returnM=false&gdbVersion=&returnDistinctValues=false&resultOffset=&resultRecordCount=&queryByDistance=&returnExtentsOnly=false&datumTransformation=&parameterValues=&rangeValues=&f=pjson");

$c = new \MongoDB\Client();

$db = $c->firstmongodb;

/*
$collection = $db->createCollection("ville");
*/

$collection = $db->ville;

foreach (json_decode($json)->features as $key => $value) {
    $document = array(
        "x" => $value->geometry->x,
        "y" => $value->geometry->y,
        "infos" => array(
            "nom" => $value->attributes->NOM,
            "adresse" => $value->attributes->ADRESSE,
            "places" => $value->attributes->PLACES,
            "capacite" => $value->attributes->CAPACITE
        )
    );
    $collection->insertOne($document);
}

$cursor = $collection->find();
