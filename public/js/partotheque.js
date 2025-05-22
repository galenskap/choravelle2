const searchInput = document.getElementById('search');

if (searchInput) {
    searchInput.addEventListener('input', function (e) {
        // Add this line to verify the event fires
        console.log('Search term:', e.target.value);

        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.partition-row').forEach(row => {
            const title = row.querySelector('[data-search="title"]').textContent.toLowerCase().trim();
            const author = row.querySelector('[data-search="author"]').textContent.toLowerCase().trim();

            if (title.includes(searchTerm) || author.includes(searchTerm)) {
                row.style.display = 'flex';
            } else {
                row.style.display = 'none';
            }
        });
    });
}