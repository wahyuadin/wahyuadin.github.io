<?php
// URL data XML dari BMKG
$xmlUrl = 'https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-JawaBarat.xml';

// Mengambil data XML dari URL
$xmlString = file_get_contents($xmlUrl);

// Memuat data XML ke dalam objek SimpleXML
$xml = simplexml_load_string($xmlString);

// Mengonversi SimpleXML ke dalam format array
$json = json_encode($xml);
$array = json_decode($json, true);

header('Content-Type: application/json');
// Menampilkan data array
echo($json);
?>
