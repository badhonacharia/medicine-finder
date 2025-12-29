<?php
require_once 'auth.php';
require_once '../includes/db.php';

$medicines = $pdo->query("
    SELECT m.id, m.brand_name, m.generic_name, m.price, m.strength,
           mf.name AS manufacturer
    FROM medicines m
    JOIN manufacturers mf ON m.manufacturer_id = mf.id
    ORDER BY m.id DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-7xl mx-auto p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <div>
            <a href="add-medicine.php" class="bg-green-600 text-white px-4 py-2 rounded mr-2">
                + Add Medicine
            </a>
            <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded">
                Logout
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Brand</th>
                    <th class="p-3 text-left">Generic</th>
                    <th class="p-3 text-left">Strength</th>
                    <th class="p-3 text-left">Manufacturer</th>
                    <th class="p-3 text-left">Price</th>
                    <th class="p-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicines as $m): ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3"><?= htmlspecialchars($m['brand_name']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($m['generic_name']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($m['strength']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($m['manufacturer']) ?></td>
                    <td class="p-3 font-semibold">৳ <?= $m['price'] ?></td>
                    <td class="p-3">
                        <a href="edit-medicine.php?id=<?= $m['id'] ?>"
                           class="text-blue-600 hover:underline">
                            Edit
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (!$medicines): ?>
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        No medicines found
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>