/**
 * Handles the display state of the View Changelog link.
 */
document.addEventListener('DOMContentLoaded', function () {
    const changelog = document.getElementById('daan-edd-sl-changelog');

    if (changelog === null) {
        return;
    }

    /**
     * Display changelog.
     */
    const changelog_link = document.getElementById('edd-sl-view-changelog');

    changelog_link.addEventListener('click', function () {
        if (changelog.style.display === 'none') {
            changelog.style.display = 'block';
        } else {
            changelog.style.display = 'none';
        }
    });
    
    /**
     * Hide changelog.
     */
    const changelog_close = document.getElementById('daan-edd-sl-changelog-close');

    if (changelog_close !== null) {
        changelog_close.addEventListener('click', function () {
            let changelog = document.getElementById('daan-edd-sl-changelog');

            changelog.style.display = 'none';
        });
    }
});