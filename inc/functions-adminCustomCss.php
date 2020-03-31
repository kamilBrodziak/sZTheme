<?php


//====================================
// PAGE
//====================================
function sZThemeCustomCssPage() {
	$context         = Timber::context();
	$timber_post     = new Timber\Post();
	$context['post'] = $timber_post;
	Timber::render( array( 'admin/adminCustomCssPage.twig' ), $context );
}

//====================================
// SETTINGS CREATION
//====================================
function sZThemeCustomCssSettings() {
	$customCssGroup = 'sZTheme-customCss-group';
	$page = 'sZThemeCustomCss';
	addSectionWithFields('customCssSection', 'Add your custom css', 'sZThemeCustomCssSection',
	                     $page, $customCssGroup,
	                     ['customCss'],
	                     ['customCss'],
	                     ['Insert your custom css here'],
	                     ['sZThemeCustomCss']);
}

//====================================
// SECTIONS
//====================================
function sZThemeCustomCssSection() {}

//====================================
// FIELDS
//====================================
function sZThemeCustomCssOptionName() {
	return 'customCss';
}

function sZThemeCustomCssOptionValue() {
	return esc_attr( get_option(sZThemeCustomCssOptionName()));
}

function sZThemeCustomCss() {
	echo generateHTMLElement("textarea", [
		'name' => sZThemeCustomCssOptionName(),
		'placeholder' => 'CSS'
	], false, sZThemeCustomCssOptionValue());
}