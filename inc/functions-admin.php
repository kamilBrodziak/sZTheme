<?php


function szczesliwyZwiazekAddAdminPage() {
	add_menu_page('Szczesliwy Zwiazek Theme Options', 'sZTheme', 'manage_options', 'sZTheme',
	              'sZThemeMainPage', 'dashicons-admin-customizer', 110);
	add_submenu_page('sZTheme', 'Settings','Settings', 'manage_options',
	                 'sZThemeSettings', 'sZThemeSettingsPage');
	add_submenu_page('sZTheme', 'Newsletter','Newsletter', 'manage_options',
	                 'sZThemeNewsletter', 'sZThemeNewsletterPage');

	add_action('admin_init', 'sZThemeNewsletterSettings');
	add_action('admin_init', 'sZThemeSettings');

}

add_action('admin_menu', 'szczesliwyZwiazekAddAdminPage');


function sZThemeMainPage() {
	$context = Timber::context();

	$timber_post = new Timber\Post();
	$context['post'] = $timber_post;
	Timber::render( array( 'admin/adminPage.twig' ), $context );
}


//====================================
// COMMON FUNC
//====================================

function addSectionWithFields($sectionId, $sectionTitle, $sectionFuncCallback, $pageSlug,
	$settingGroup, $settingOptionNameArray, $fieldIdArray, $fieldTitleArray,
	$fieldFuncCallbackArray) {
	add_settings_section($sectionId, $sectionTitle, $sectionFuncCallback, $pageSlug);
	foreach ($settingOptionNameArray as $settingOptionName) {
		register_setting($settingGroup, $settingOptionName, 'sanitizeInput');
	}
	for($i = 0; $i < count($fieldIdArray); $i++) {
		add_settings_field($fieldIdArray[$i], $fieldTitleArray[$i], $fieldFuncCallbackArray[$i], $pageSlug, $sectionId);
	}
}

function sanitizeInput($input) {
	return sanitize_text_field($input);
}

