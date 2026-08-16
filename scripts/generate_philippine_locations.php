<?php

$baseUrl = 'https://psgc.gitlab.io/api';

$fetchJson = function (string $path) use ($baseUrl): array {
    $url = $baseUrl . $path;
    $contents = @file_get_contents($url);

    if ($contents === false) {
        throw new RuntimeException("Unable to fetch {$url}");
    }

    $decoded = json_decode($contents, true);
    if (!is_array($decoded)) {
        throw new RuntimeException("Invalid JSON payload for {$url}");
    }

    return $decoded;
};

$regions = $fetchJson('/regions.json');
$provinces = $fetchJson('/provinces.json');
$cities = $fetchJson('/cities-municipalities.json');
$barangays = $fetchJson('/barangays.json');

$data = [
    'regions' => [],
    'provinces' => [],
    'cities_municipalities' => [],
    'barangays' => [],
];

foreach ($regions as $row) {
    $code = (string) ($row['code'] ?? '');
    $name = trim((string) ($row['regionName'] ?? $row['name'] ?? ''));

    if ($code === '' || $name === '') {
        continue;
    }

    $data['regions'][] = [
        'code' => $code,
        'name' => $name,
        'country' => 'Philippines',
    ];
}

foreach ($provinces as $row) {
    $code = (string) ($row['code'] ?? '');
    $regionCode = (string) ($row['regionCode'] ?? '');
    $name = trim((string) ($row['name'] ?? ''));

    if ($code === '' || $regionCode === '' || $name === '') {
        continue;
    }

    $data['provinces'][] = [
        'code' => $code,
        'region_code' => $regionCode,
        'name' => $name,
    ];
}

foreach ($cities as $row) {
    $code = (string) ($row['code'] ?? '');
    $regionCode = (string) ($row['regionCode'] ?? '');
    $name = trim((string) ($row['name'] ?? ''));
    $provinceCode = $row['provinceCode'] ?? null;
    $provinceCode = $provinceCode === false || $provinceCode === '' ? null : (string) $provinceCode;

    if ($code === '' || $regionCode === '' || $name === '') {
        continue;
    }

    $type = 'Local Government Unit';
    if (!empty($row['isCity'])) {
        $type = 'City';
    } elseif (!empty($row['isMunicipality'])) {
        $type = 'Municipality';
    }

    $data['cities_municipalities'][] = [
        'code' => $code,
        'region_code' => $regionCode,
        'province_code' => $provinceCode,
        'name' => $name,
        'type' => $type,
    ];
}

foreach ($barangays as $row) {
    $code = (string) ($row['code'] ?? '');
    $municipalityCode = $row['municipalityCode'] ?? null;
    $cityCode = $row['cityCode'] ?? null;
    $municipalityCode = $municipalityCode === false || $municipalityCode === '' ? null : (string) $municipalityCode;
    $cityCode = $cityCode === false || $cityCode === '' ? null : (string) $cityCode;
    $cityMunicipalityCode = $municipalityCode ?: $cityCode ?: '';
    $name = trim((string) ($row['name'] ?? ''));

    if ($code === '' || $cityMunicipalityCode === '' || $name === '') {
        continue;
    }

    $data['barangays'][] = [
        'code' => $code,
        'city_municipality_code' => $cityMunicipalityCode,
        'name' => $name,
    ];
}

$outputDir = __DIR__ . '/../database/data';
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

$outputPath = $outputDir . '/philippine_locations.php';
$export = var_export($data, true);
$contents = "<?php\n\nreturn " . $export . ";\n";
file_put_contents($outputPath, $contents);

echo "Generated {$outputPath}\n";
echo "Regions: " . count($data['regions']) . "\n";
echo "Provinces: " . count($data['provinces']) . "\n";
echo "Cities/Municipalities: " . count($data['cities_municipalities']) . "\n";
echo "Barangays: " . count($data['barangays']) . "\n";
