<?php
require_once '../includes/db.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? 0;
if (!$id) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT generic_name, strength, dosage_form
    FROM medicines
    WHERE id = ?
");
$stmt->execute([$id]);
$base = $stmt->fetch();

if (!$base) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT 
        m.brand_name,
        m.generic_name,
        m.strength,
        m.dosage_form,
        m.price,
        mf.name AS manufacturer
    FROM medicines m
    JOIN manufacturers mf ON m.manufacturer_id = mf.id
    WHERE m.generic_name = ?
      AND m.strength = ?
      AND m.id != ?
      AND m.status = 'active'
    ORDER BY m.price ASC
");

$stmt->execute([
    $base['generic_name'],
    $base['strength'],
    $id
]);

echo json_encode($stmt->fetchAll());
