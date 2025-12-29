<?php
require_once 'auth.php';
require_once '../includes/db.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM medicines WHERE id = ?");
$stmt->execute([$id]);
$medicine = $stmt->fetch();

if (!$medicine) {
    die('Medicine not found');
}

$manufacturers = $pdo->query("SELECT * FROM manufacturers")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("
        UPDATE medicines SET
        brand_name=?, generic_name=?, strength=?, dosage_form=?,
        price=?, manufacturer_id=?, category=?
        WHERE id=?
    ");

    $stmt->execute([
        $_POST['brand_name'],
        $_POST['generic_name'],
        $_POST['strength'],
        $_POST['dosage_form'],
        $_POST['price'],
        $_POST['manufacturer_id'],
        $_POST['category'],
        $id
    ]);

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Medicine</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-10 bg-white p-6 shadow rounded">
    <h2 class="text-xl font-bold mb-4">Edit Medicine</h2>

    <form method="post" class="space-y-3">
        <input name="brand_name" value="<?= htmlspecialchars($medicine['brand_name']) ?>" class="w-full border p-2 rounded">
        <input name="generic_name" value="<?= htmlspecialchars($medicine['generic_name']) ?>" class="w-full border p-2 rounded">
        <input name="strength" value="<?= htmlspecialchars($medicine['strength']) ?>" class="w-full border p-2 rounded">
        <input name="dosage_form" value="<?= htmlspecialchars($medicine['dosage_form']) ?>" class="w-full border p-2 rounded">
        <input name="price" value="<?= htmlspecialchars($medicine['price']) ?>" class="w-full border p-2 rounded">

        <select name="manufacturer_id" class="w-full border p-2 rounded">
            <?php foreach ($manufacturers as $m): ?>
                <option value="<?= $m['id'] ?>"
                    <?= $m['id'] == $medicine['manufacturer_id'] ? 'selected' : '' ?>>
                    <?= $m['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input name="category" value="<?= htmlspecialchars($medicine['category']) ?>" class="w-full border p-2 rounded">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update Medicine
        </button>
    </form>
</div>

</body>
</html>
