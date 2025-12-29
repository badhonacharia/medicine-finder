<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($_POST['password'], $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: dashboard.php');
        exit;
    }

    $error = "Invalid login";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<form method="post" class="bg-white p-6 rounded shadow w-80">
    <h2 class="text-xl font-bold mb-4">Admin Login</h2>

    <?php if (!empty($error)): ?>
        <p class="text-red-500 text-sm mb-2"><?= $error ?></p>
    <?php endif; ?>

    <input name="username" placeholder="Username" class="w-full border p-2 mb-3" required>
    <input name="password" type="password" placeholder="Password" class="w-full border p-2 mb-3" required>

    <button class="bg-blue-600 text-white w-full py-2 rounded">
        Login
    </button>
</form>

</body>
</html>
