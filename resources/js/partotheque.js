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
        <button class="zoom-button" id="printLyrics" title="Imprimer les paroles">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
            </svg>
        </button>
    `;

    // Insert zoom controls before lyrics content
    lyricsContent.parentNode.insertBefore(zoomControls, lyricsContent);

    // Add lyrics-content class to the lyrics container
    lyricsContent.classList.add('lyrics-content');

    const MIN_SIZE = 12;
    const MAX_SIZE = 48;
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

    // Add print functionality
    const printButton = document.getElementById('printLyrics');
    if (printButton) {
        // Add print-only class to lyrics content
        lyricsContent.classList.add('prose-print-only');
        
        // Create print title element
        const printTitle = document.createElement('h1');
        printTitle.className = 'print-title text-2xl font-bold';
        printTitle.textContent = document.querySelector('h2').textContent; // Get the song title from the header
        lyricsContent.parentNode.insertBefore(printTitle, lyricsContent);
        
        printButton.addEventListener('click', () => {
            window.print();
        });
    }
});