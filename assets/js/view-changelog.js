/**
 * Handles the display state of the View Changelog link.
 */
document.addEventListener('DOMContentLoaded', function () {
    /**
     * Display changelog.
     */
    document.getElementById('edd-sl-view-changelog').addEventListener('click', function () {
        let changelog = document.getElementById('daan-edd-sl-changelog');

        if (changelog.style.display === 'none') {
            changelog.style.display = 'block';
        } else {
            changelog.style.display = 'none';
        }
    });

    /**
     * Hide changelog.
     */
    document.getElementById('daan-edd-sl-close-changelog').addEventListener('click', function () {
        let changelog = document.getElementById('daan-edd-sl-changelog');

        changelog.style.display = 'none';
    });
});