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

// Lyrics zoom functionality
document.addEventListener('DOMContentLoaded', function() {
    const lyricsContent = document.querySelector('.prose');
    if (!lyricsContent) return;

    // Add zoom controls
    const zoomControls = document.createElement('div');
    zoomControls.className = 'zoom-controls';
    zoomControls.innerHTML = `
        <button class="zoom-button" id="zoomOut" title="Réduire la taille du texte">
            <span style="font-weight: bold; font-size: 14px">A-</span>
        </button>
        <button class="zoom-button" id="zoomIn" title="Augmenter la taille du texte">
            <span style="font-weight: bold; font-size: 18px">A+</span>
        </button>
    `;

    // Insert zoom controls before lyrics content
    lyricsContent.parentNode.insertBefore(zoomControls, lyricsContent);

    // Add lyrics-content class to the lyrics container
    lyricsContent.classList.add('lyrics-content');

    const MIN_SIZE = 16;
    const MAX_SIZE = 32;
    const STEP_SIZE = 2;
    
    let currentSize = parseInt(window.getComputedStyle(lyricsContent).fontSize);

    const zoomIn = document.getElementById('zoomIn');
    const zoomOut = document.getElementById('zoomOut');

    function updateZoomButtons() {
        zoomIn.disabled = currentSize >= MAX_SIZE;
        zoomOut.disabled = currentSize <= MIN_SIZE;
    }

    zoomIn.addEventListener('click', () => {
        if (currentSize < MAX_SIZE) {
            currentSize += STEP_SIZE;
            lyricsContent.style.fontSize = currentSize + 'px';
            updateZoomButtons();
        }
    });

    zoomOut.addEventListener('click', () => {
        if (currentSize > MIN_SIZE) {
            currentSize -= STEP_SIZE;
            lyricsContent.style.fontSize = currentSize + 'px';
            updateZoomButtons();
        }
    });

    // Initialize button states
    updateZoomButtons();
});