const { registerBlockVariation } = wp.blocks;
const { addFilter } = wp.hooks;
const { createElement, Fragment, Children, cloneElement} = wp.element;
const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl, TextareaControl, Button, ColorPalette } = wp.components;
const { __ } = wp.i18n; 

// Default attributes for the block.
const DEFAULT_ATTRIBUTES = {
	captionLinkColor: { type: 'string', default: '#000000' },
	captionText: { type: 'string', default: '' },
	linkUrl: { type: 'string', default: '' },
	linkText: { type: 'string', default: '' },
};

// Available colors for the ColorPalette component.
const COLORS = [
	{ name: 'Red', color: '#ff0000' },
	{ name: 'White', color: '#ffffff' },
	{ name: 'Blue', color: '#0000ff' },
	{ name: 'Black', color: '#000000' },
];

/**
 * Helper function to escape HTML input.
 */
const escapeHTML = ( unsafe ) => (
	unsafe.replace( /&/g, "&amp;" )
		.replace( /</g, "&lt;" )
		.replace( />/g, "&gt;" )
		.replace( /"/g, "&quot;" )
);

/**
 * Helper function to sanitize color input.
 */
const isValidHexColor = color => /^#([0-9A-F]{3}){1,2}$/i.test( color );

/**
 * Function to render the link with the chosen color.
 */
function renderLinkPreview( captionText, linkColor ) {
    const tempDiv = document.createElement( 'div' );
    tempDiv.innerHTML = captionText;

    const links = tempDiv.querySelectorAll( 'a' );
    links.forEach( link => {
        link.style.color = linkColor;
    } );

    return tempDiv.innerHTML;
}

/**
 * Add custom attributes to the block.
 */
function addCustomAttributes( settings ) {
	if ( settings.attributes ) {
		settings.attributes = { ...settings.attributes, ...DEFAULT_ATTRIBUTES };
	}
	return settings;
}

addFilter(
	'blocks.registerBlockType',
	'jetpack/map',
	addCustomAttributes
);

/**
 * Higher Order Component to add InspectorControls to the Map block.
 */
const withMapMarkerLinkControls = createHigherOrderComponent( ( BlockEdit ) => {
	return function (props) {
		const { name, attributes, setAttributes } = props;
		const { captionText, captionLinkColor = '#000000', linkUrl, linkText } = attributes;

		// Ensure the controls only apply to the 'jetpack/map' block.
		if ( name !== 'jetpack/map' ) {
			return createElement( BlockEdit, props );
		}

		// Handle adding a link to the caption text.
		const addLink = () => {
			if ( linkUrl && linkText ) {
				const newCaptionText = `${captionText} <a href="${escapeHTML( linkUrl )}">${escapeHTML( linkText )}</a>`;
				setAttributes( { 
					captionText: newCaptionText, 
					caption: newCaptionText, 
					linkUrl: '', 
					linkText: '' 
				} );
			}
		};

		return createElement(
			Fragment,
			null,
			createElement( BlockEdit, props ),
			createElement(
				InspectorControls,
				null,
				createElement(
					PanelBody,
					{ title: __( 'Caption Link Settings', 'ka-jetpack-maps-custom-caption-links' ) },
					createElement( 'h3', null, __( 'Caption Link Color', 'ka-jetpack-maps-custom-caption-links' ) ),
					createElement( ColorPalette, {
						colors: COLORS,
						value: captionLinkColor,
						onChange: ( value ) => {
							setAttributes( { captionLinkColor: value } );
        
						},
						help: __( 'Enter your chosen caption link color. Defaults to existing theme defaults.', 'ka-jetpack-maps-custom-caption-links' )
					}),
					createElement( 'h2', null, __( 'Test out adding a link to your caption text below:', 'ka-jetpack-maps-custom-caption-links' ) ),
					createElement( TextareaControl, {
						label: __( 'Caption Text', 'ka-jetpack-maps-custom-caption-links' ),
						value: captionText,
						onChange: ( value ) => setAttributes( { captionText: value } ),
						help: __( 'Enter your caption text. You can add links below. Once generated using the "Add Link" button, you can copy the result in this box.', 'ka-jetpack-maps-custom-caption-links' )
					}),
					createElement( TextControl, {
						label: __( 'Link URL', 'ka-jetpack-maps-custom-caption-links' ),
						value: linkUrl,
						onChange: ( value ) => setAttributes( { linkUrl: value } ),
						placeholder: 'https://example.com'
					}),
					createElement( TextControl, {
						label: __( 'Link Text' , 'ka-jetpack-maps-custom-caption-links' ),
						value: linkText,
						onChange: ( value ) => setAttributes( { linkText: value } ),
						placeholder: __( 'Click Here', 'ka-jetpack-maps-custom-caption-links' )
					}),
					createElement( Button, {
						isPrimary: true,
						onClick: addLink
					}, __( 'Add Link', 'ka-jetpack-maps-custom-caption-links' ) ),
					createElement(
						'div',
						{ style: { marginTop: '10px' } },
						__( 'Preview:', 'ka-jetpack-maps-custom-caption-links' ),
						createElement( 'div', {
							dangerouslySetInnerHTML: { __html: renderLinkPreview( captionText, captionLinkColor ) }
						})
					)
				)
			)
		);
	};
}, 'withMapMarkerLinkControls' );

addFilter(
	'editor.BlockEdit',
	'jetpack/map',
	withMapMarkerLinkControls
);

