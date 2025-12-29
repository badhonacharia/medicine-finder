const searchInput = document.getElementById('searchInput');
const resultsBox = document.getElementById('results');

let timer = null;

searchInput.addEventListener('keyup', () => {
    clearTimeout(timer);

    const query = searchInput.value.trim();

    if (query.length < 2) {
        resultsBox.innerHTML = '';
        return;
    }

    timer = setTimeout(() => {
        fetch(`api/search-medicine.php?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                renderResults(data);
            })
            .catch(() => {
                resultsBox.innerHTML = '<p class="text-red-500">Error loading data</p>';
            });
    }, 300);
});

function renderResults(data) {
    if (!data.length) {
        resultsBox.innerHTML = '<p class="text-gray-500">No medicine found</p>';
        return;
    }

    resultsBox.innerHTML = data.map(med => `
        <div class="border rounded-lg p-4 bg-gray-50 hover:bg-white transition">
            <h3 class="text-lg font-semibold">${med.brand_name}</h3>

            <p class="text-sm text-gray-600">
                Generic: <strong>${med.generic_name}</strong>
            </p>

            <p class="text-sm">
                Strength: ${med.strength} | ${med.dosage_form}
            </p>

            <p class="text-sm">
                Manufacturer: ${med.manufacturer}
            </p>

            <p class="text-lg font-bold text-blue-600 mt-2">
                ৳ ${med.price}
            </p>

            <a href="medicine.php?id=${med.id}"
               class="inline-block mt-3 text-sm text-blue-500 hover:underline">
               View alternatives →
            </a>
        </div>
    `).join('');
}
