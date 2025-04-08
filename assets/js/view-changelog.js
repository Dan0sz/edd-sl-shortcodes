/**
 * Handles the display state of the View Changelog link.
 */
document.addEventListener('DOMContentLoaded', function () {
    const changelog = document.getElementById('daan-edd-sl-changelog');

    /**
     * Display changelog.
     */
    if (changelog !== null) {
        changelog.addEventListener('click', function () {
            let changelog = document.getElementById('daan-edd-sl-changelog');

            if (changelog.style.display === 'none') {
                changelog.style.display = 'block';
            } else {
                changelog.style.display = 'none';
            }
        });
    }

    const changelog_close = document.getElementById('daan-edd-sl-changelog-close');

    /**
     * Hide changelog.
     */
    if (changelog_close !== null) {
        changelog_close.addEventListener('click', function () {
            let changelog = document.getElementById('daan-edd-sl-changelog');

            changelog.style.display = 'none';
        });
    }
});