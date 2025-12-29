<?php
require_once 'includes/db.php';

$id = $_GET['id'] ?? 0;
if (!$id) {
    die('Invalid medicine');
}

$stmt = $pdo->prepare("
    SELECT m.*, mf.name AS manufacturer
    FROM medicines m
    JOIN manufacturers mf ON m.manufacturer_id = mf.id
    WHERE m.id = ?
");
$stmt->execute([$id]);
$medicine = $stmt->fetch();

if (!$medicine) {
    die('Medicine not found');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($medicine['brand_name']) ?> Price in Bangladesh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto p-6">

    <!-- Medicine Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold"><?= htmlspecialchars($medicine['brand_name']) ?></h1>

        <p class="text-gray-600 mt-1">
            Generic: <strong><?= htmlspecialchars($medicine['generic_name']) ?></strong>
        </p>

        <p class="mt-2">
            Strength: <?= htmlspecialchars($medicine['strength']) ?> |
            <?= htmlspecialchars($medicine['dosage_form']) ?>
        </p>

        <p class="mt-1">
            Manufacturer: <?= htmlspecialchars($medicine['manufacturer']) ?>
        </p>

        <p class="text-2xl font-bold text-blue-600 mt-4">
            ৳ <?= number_format($medicine['price'], 2) ?>
        </p>
    </div>

    <!-- Alternatives -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">
            Cheaper Alternatives
        </h2>

        <div id="alternatives">
            <p class="text-gray-500">Loading alternatives...</p>
        </div>
    </div>

    <!-- Disclaimer -->
    <p class="text-xs text-gray-500 mt-6">
        ⚠️ This information is for educational purposes only.
        Always consult a registered physician or pharmacist before switching medicines.
    </p>

</div>

<script>
fetch(`api/get-alternatives.php?id=<?= $medicine['id'] ?>`)
    .then(res => res.json())
    .then(data => {
        const box = document.getElementById('alternatives');

        if (!data.length) {
            box.innerHTML = '<p class="text-gray-500">No alternatives found</p>';
            return;
        }

        box.innerHTML = data.map(m => `
            <div class="border rounded p-4 mb-3 bg-gray-50">
                <h3 class="font-semibold">${m.brand_name}</h3>
                <p class="text-sm text-gray-600">
                    ${m.generic_name} • ${m.strength} • ${m.dosage_form}
                </p>
                <p class="text-sm">
                    Manufacturer: ${m.manufacturer}
                </p>
                <p class="font-bold text-green-600 mt-1">
                    ৳ ${m.price}
                </p>
            </div>
        `).join('');
    });
</script>

</body>
</html>
