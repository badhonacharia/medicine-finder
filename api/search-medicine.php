<?php
require_once '../includes/db.php';
header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');

if (strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

/*
|--------------------------------------------------------------------------
| 1️⃣ SEARCH LOCAL DATABASE FIRST
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT 
        m.id,
        m.brand_name,
        m.generic_name,
        m.strength,
        m.dosage_form,
        m.price,
        mf.name AS manufacturer,
        'local' AS source
    FROM medicines m
    JOIN manufacturers mf ON m.manufacturer_id = mf.id
    WHERE m.brand_name LIKE :q
       OR m.generic_name LIKE :q
    LIMIT 20
");

$stmt->execute(['q' => "%$q%"]);
$localResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ✅ If local data exists, return it */
if (!empty($localResults)) {
    echo json_encode($localResults);
    exit;
}

/*
|--------------------------------------------------------------------------
| 2️⃣ CHECK API CACHE (OPTIONAL BUT RECOMMENDED)
|--------------------------------------------------------------------------
*/
$cacheStmt = $pdo->prepare("
    SELECT response
    FROM api_cache
    WHERE query = ?
      AND created_at >= NOW() - INTERVAL 7 DAY
    LIMIT 1
");
$cacheStmt->execute([$q]);
$cached = $cacheStmt->fetch();

if ($cached) {
    echo $cached['response'];
    exit;
}


/*
|--------------------------------------------------------------------------
| 3️⃣ FETCH FROM RxNorm (GENERIC + BRAND SAFE)
|--------------------------------------------------------------------------
*/

// 1️⃣ Try normal drug search (generic-friendly)
$apiUrl = "https://rxnav.nlm.nih.gov/REST/drugs.json?name=" . urlencode($q);
$apiResponse = @file_get_contents($apiUrl);

$data = json_decode($apiResponse, true);
$apiResults = [];

// Parse generic results
if (!empty($data['drugGroup']['conceptGroup'])) {
    foreach ($data['drugGroup']['conceptGroup'] as $group) {
        if (!empty($group['conceptProperties'])) {
            foreach ($group['conceptProperties'] as $drug) {
                $apiResults[] = [
                    'id'            => null,
                    'brand_name'    => $drug['name'],
                    'generic_name'  => $q,
                    'strength'      => null,
                    'dosage_form'   => null,
                    'price'         => null,
                    'manufacturer'  => 'N/A',
                    'source'        => 'api'
                ];
            }
        }
    }
}

// 2️⃣ If NOTHING found → try approximate (brand-safe)
if (empty($apiResults)) {

    $approxUrl = "https://rxnav.nlm.nih.gov/REST/approximateTerm.json?term=" . urlencode($q) . "&maxEntries=10";
    $approxResponse = @file_get_contents($approxUrl);
    $approxData = json_decode($approxResponse, true);

    if (!empty($approxData['approximateGroup']['candidate'])) {
        foreach ($approxData['approximateGroup']['candidate'] as $item) {

            $rxcui = $item['rxcui'];

            // Fetch name from RXCUI
            $nameUrl = "https://rxnav.nlm.nih.gov/REST/rxcui/$rxcui/property.json?propName=RxNorm%20Name";
            $nameResponse = @file_get_contents($nameUrl);
            $nameData = json_decode($nameResponse, true);

            if (!empty($nameData['propConceptGroup']['propConcept'][0]['propValue'])) {
                $apiResults[] = [
                    'id'            => null,
                    'brand_name'    => $nameData['propConceptGroup']['propConcept'][0]['propValue'],
                    'generic_name'  => 'Unknown',
                    'strength'      => null,
                    'dosage_form'   => null,
                    'price'         => null,
                    'manufacturer'  => 'N/A',
                    'source'        => 'api'
                ];
            }
        }
    }
}

$apiResults = array_slice($apiResults, 0, 20);

/*
|--------------------------------------------------------------------------
| 4️⃣ SAVE API RESPONSE TO CACHE
|--------------------------------------------------------------------------
*/
if (!empty($apiResults)) {
    $stmt = $pdo->prepare("
        INSERT INTO api_cache (query, response)
        VALUES (?, ?)
    ");
    $stmt->execute([$q, json_encode($apiResults)]);
}

echo json_encode($apiResults);
