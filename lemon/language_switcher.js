/**
 * File: language_switcher.js
 * Author: Pan Zitao
 * Date: 2025-07-22
 * Description: Handles AJAX-based language switching with a page reload.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Find all language switch buttons
    const langButtons = document.querySelectorAll('.lang-switch-btn');

    langButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Stop the link from causing a normal page navigation
            event.preventDefault(); 

            const langCode = this.getAttribute('data-lang');

            fetch('switch_language.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ lang: langCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // This is the simple and direct method: just reload the page.
                    location.reload();
                } else {
                    console.error('Language switch failed on the server.');
                }
            })
            .catch(error => console.error('Language switch AJAX error:', error));
        });
    });
});