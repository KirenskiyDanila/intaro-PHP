<?php

$apiKey = $ini_array = parse_ini_file("secret.ini", true)['apiKey'];

// параметры для получения координат и адреса
$params = [
    'apikey' => $apiKey,
    'geocode' => $_POST['address'],
    'format' => 'json',
];
$response = file_get_contents('https://geocode-maps.yandex.ru/1.x/?' . http_build_query($params));
$result = json_decode($response, true);
// для чистоты кода
$result = $result['response']['GeoObjectCollection']['featureMember'][0]['GeoObject'];
$address = $result['metaDataProperty']['GeocoderMetaData']['text'];
$coordinates = str_replace(" ", ",", $result['boundedBy']['Envelope']['lowerCorner']);
// параметры для получения данных о метро
$parameters = array(
    'apikey' => $apiKey,
    'geocode' => $coordinates,
    'kind' => 'metro',
    'format' => 'json',
    'results' => '1'
);
$response = file_get_contents('https://geocode-maps.yandex.ru/1.x/?' . http_build_query($parameters));
$result = json_decode($response, true);
$metro = ($result['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['text']);

echo json_encode([
    'address' => $address,
    'coordinates' => $coordinates,
    'metro' => $metro,
]);