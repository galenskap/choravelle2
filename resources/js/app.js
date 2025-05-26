import './bootstrap';
import './partotheque';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Gestion des infobulles des icônes sur mobile
document.addEventListener('DOMContentLoaded', function() {
    const iconItems = document.querySelectorAll('.icon-item');
    
    iconItems.forEach(item => {
        item.addEventListener('click', function() {
            // Sur mobile uniquement
            if (window.innerWidth < 768) {
                // Ferme toutes les autres infobulles
                iconItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });
                
                // Toggle l'infobulle courante
                this.classList.toggle('active');
            }
        });
    });
    
    // Ferme l'infobulle si on clique ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.icon-item')) {
            iconItems.forEach(item => item.classList.remove('active'));
        }
    });
});
