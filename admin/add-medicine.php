<?php
require_once 'auth.php';
require_once '../includes/db.php';

$manufacturers = $pdo->query("SELECT * FROM manufacturers")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("
        INSERT INTO medicines
        (brand_name, generic_name, strength, dosage_form, price, manufacturer_id, category)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['brand_name'],
        $_POST['generic_name'],
        $_POST['strength'],
        $_POST['dosage_form'],
        $_POST['price'],
        $_POST['manufacturer_id'],
        $_POST['category']
    ]);

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Medicine</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-10 bg-white p-6 shadow rounded">
    <h2 class="text-xl font-bold mb-4">Add Medicine</h2>

    <form method="post" class="space-y-3">
        <input name="brand_name" placeholder="Brand Name" class="w-full border p-2 rounded" required>
        <input name="generic_name" placeholder="Generic Name" class="w-full border p-2 rounded" required>
        <input name="strength" placeholder="Strength (e.g. 500 mg)" class="w-full border p-2 rounded">
        <input name="dosage_form" placeholder="Dosage Form (Tablet/Syrup)" class="w-full border p-2 rounded">
        <input name="price" type="number" step="0.01" placeholder="Price" class="w-full border p-2 rounded">

        <select name="manufacturer_id" class="w-full border p-2 rounded">
            <?php foreach ($manufacturers as $m): ?>
                <option value="<?= $m['id'] ?>"><?= $m['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <input name="category" placeholder="Category (Painkiller, Antibiotic)" class="w-full border p-2 rounded">

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Save Medicine
        </button>
    </form>
</div>

</body>
</html>
