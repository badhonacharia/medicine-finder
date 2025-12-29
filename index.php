<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medicine Price Finder Bangladesh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<!-- Header -->
<header class="bg-blue-600 text-white py-5 shadow">
    <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-2xl font-bold">💊 Medicine Price & Alternative Finder</h1>
        <p class="text-sm opacity-90">Search medicine prices in Bangladesh</p>
    </div>
</header>

<!-- Search Section -->
<section class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow">

        <input
            type="text"
            id="searchInput"
            placeholder="Search by brand or generic name (e.g. Napa, Paracetamol)"
            class="w-full border border-gray-300 rounded px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >

        <!-- Results -->
        <div id="results" class="mt-6 space-y-4"></div>

        <!-- Disclaimer -->
        <p class="text-xs text-gray-500 mt-6">
            ⚠️ This information is for educational purposes only.
            Always consult a registered doctor or pharmacist before switching medicines.
        </p>

    </div>
</section>

<script src="assets/js/app.js"></script>
</body>
</html>
