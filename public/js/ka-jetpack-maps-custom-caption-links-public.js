/**
 * Helper function to escape HTML input.
 */
function escapeHTML( unsafe ) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
}

/**
 * Helper function to determine if a URL is valid.
 */
function isValidURL( url ) {
    try {
        new URL( url );
        return true;
    } catch {
        return false;
    }
}

/**
 * Once a map marker caption is opened, check if it contains a link and update the caption accordingly.
 */ 
window.addEventListener('click', function () {
    // Get the Mapbox popup caption
    const theCaption = document.querySelector( '.mapboxgl-popup-content p' );
    if ( ! theCaption ) {
		return;
	}

    // Get parent block and its caption link color attribute
    const parentMapBlock = theCaption.closest( '.wp-block-jetpack-map' );
    const captionLinkColor = parentMapBlock?.getAttribute( 'data-caption-link-color' ) || '';

  	// Check if the caption contains an anchor tag
    if ( theCaption.innerText.includes( '<a href' ) ) {
        const theCaptionText = theCaption.innerText;

        // Regular expression to match <a> tag and extract href and inner content
        const linkRegex = /<a\s+href="([^"]+)"\s*>([^<]+)<\/a>/;
        const match = theCaptionText.match( linkRegex );

        if ( match ) {
            const href = escapeHTML( match[1] );
            const linkText = escapeHTML( match[2] );

            // Remove <a> tag from the original string
            const plainText = theCaptionText.replace( linkRegex, '' );

            if ( isValidURL( href ) ) {
                // Build and update the HTML string
                const htmlString = `${escapeHTML( plainText )} <a class="ka-jetpack-maps-custom-caption-links-link" href="${href}" target="_blank" style="color:${captionLinkColor}">${linkText}</a>`;
                theCaption.innerHTML = htmlString;
            } else {
                console.warn( 'Invalid URL detected: ' + href );
            }
        } else {
            // No link found, escape and sanitize the original text
            theCaption.innerHTML = escapeHTML( theCaptionText );
        }
    }
} );
