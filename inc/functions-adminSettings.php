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
	addSectionWithFields('tableOfContentsSection', 'Enable or disable table of contents layout', 'sZThemeTableOfContentsSection',
	                     $page, $settingsGroup,
	                     ['tableOfContents'],
	                     ['tableOfContents'],
	                     ['Enable table of contents layout'],
	                     ['sZThemeSettingsTableOfContents']);
	addSectionWithFields('menuShopAnimationSection', 'Choose animation for shop menu item', 'sZThemeShopMenuAnimationSection',
	                     $page, $settingsGroup,
	                     ['shopMenuAnimation'],
	                     ['shopMenuAnimation'],
	                     ['Choose animation'],
	                     ['sZThemeSettingsShopMenuAnimation']);
}


//====================================
// SECTIONS
//====================================
function sZThemeGutenbergSection() {}
function sZThemeTableOfContentsSection() {}
function sZThemeShopMenuAnimationSection() {}

//====================================
// FIELDS
//====================================

//GUTENBERG
$optionName = 'gutenbergDisable';
$isGutenbergDisabled = esc_attr( get_option($optionName));
if($isGutenbergDisabled) {
	add_filter('use_block_editor_for_post', '__return_false');
	add_filter('use_block_editor_for_post_type', '__return_false');
}

function sZThemeSettingsGutenbergOptionName() {
	return 'gutenbergDisable';
}

function sZThemeSettingsGutenbergOptionValue() {
	return esc_attr( get_option(sZThemeSettingsGutenbergOptionName()));
}

function sZThemeSettingsGutenberg() {
	if(sZThemeSettingsGutenbergOptionValue()) {
		echo generateHTMLElement("input" ,
             [
                 'name' => sZThemeSettingsGutenbergOptionName(),
                 'type' => 'checkbox',
                 'checked' => 'checked'
             ]
		);
	} else {
		echo generateHTMLElement("input" ,
             [
                 'name' => sZThemeSettingsGutenbergOptionName(),
                 'type' => 'checkbox',
             ]
		);
	}
}

// TABLE OF CONTENTS

function sZThemeSettingsTableOfContentsOptionName() {
	return 'tableOfContents';
}

function sZThemeSettingsTableOfContentsOptionValue() {
	return esc_attr( get_option(sZThemeSettingsTableOfContentsOptionName()));
}

function sZThemeSettingsTableOfContents() {
	if(sZThemeSettingsTableOfContentsOptionValue()) {
		echo generateHTMLElement("input" ,
             [
                 'name' => sZThemeSettingsTableOfContentsOptionName(),
                 'type' => 'checkbox',
                 'checked' => 'checked'
             ]
		);
	} else {
		echo generateHTMLElement("input" ,
             [
                 'name' => sZThemeSettingsTableOfContentsOptionName(),
                 'type' => 'checkbox',
             ]
		);
	}
}

function sZThemeSettingsShopMenuOptionName() {
	return 'shopMenuAnimation';
}

function sZThemeSettingsShopMenuOptionValue() {
	return esc_attr( get_option(sZThemeSettingsShopMenuOptionName()));
}

function sZThemeSettingsShopMenuAnimation() {
	$isSelected = [];
	$isSelected['disabled'] = '';
	$isSelected['pulseAnimationButton'] = '';
	$isSelected['snakeAnimationButton'] = '';
	$isSelected[sZThemeSettingsShopMenuOptionValue()] = 'selected';
	$options = [];
	$options['disabled'] = generateHTMLElement("option",
		[
			'name'=>'disabled',
			'value'=>'disabled',
			$isSelected['disabled'] => $isSelected['disabled']
		], false, "Disabled");
	$options['pulseAnimationButton'] = generateHTMLElement("option",
           [
               'name'=>'pulseAnimationButton',
               'value'=>'pulseAnimationButton',
               $isSelected['pulseAnimationButton'] => $isSelected['pulseAnimationButton']
           ], false, "Pulse");
	$options['snakeAnimationButton'] = generateHTMLElement("option",
           [
               'name'=>'snakeAnimationButton',
               'value'=>'snakeAnimationButton',
               $isSelected['snakeAnimationButton'] => $isSelected['snakeAnimationButton']
           ], false, 'Snake');
	echo generateHTMLElement("select" ,
         [
             'name' => sZThemeSettingsShopMenuOptionName(),
         ], false, $options['disabled'] . $options['pulseAnimationButton'] . $options['snakeAnimationButton']
	);
}