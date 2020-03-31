<?php

//====================================
// PAGE
//====================================
function sZThemeSettingsPage() {
	$context = Timber::context();

	$timber_post = new Timber\Post();
	$context['post'] = $timber_post;
	Timber::render( array( 'admin/adminSettingsPage.twig' ), $context );
}

//====================================
// SETTINGS CREATION
//====================================

function sZThemeSettings() {
	$settingsGroup = 'sZTheme-settings-group';
	$page = 'sZThemeSettings';

	addSectionWithFields('gutenbergSection', 'Enable or disable gutenberg', 'sZThemeGutenbergSection',
	                     $page, $settingsGroup,
	                     ['gutenbergDisable'],
	                     ['gutenbergDisable'],
	                     ['Disable gutenberg'],
	                     ['sZThemeSettingsGutenberg']);
}


//====================================
// SECTIONS
//====================================
function sZThemeGutenbergSection() {}


//====================================
// FIELDS
//====================================
$optionName = 'gutenbergDisable';
$isGutenbergDisabled = esc_attr( get_option($optionName));
if($isGutenbergDisabled) {
	add_filter('use_block_editor_for_post', '__return_false');
	add_filter('use_block_editor_for_post_type', '__return_false');
}
function sZThemeSettingsGutenberg() {
	$optionName = 'gutenbergDisable';
	$isGutenbergDisabled = esc_attr( get_option($optionName));
	$optionValue = ($isGutenbergDisabled) ? 'checked' : '';

	echo '<input type="checkbox" maxlength="80" size=90 name="' . $optionName . '"' . $optionValue . ' placeholder="Header text">';
}