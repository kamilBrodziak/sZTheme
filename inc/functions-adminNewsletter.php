<?php
//====================================
// PAGE
//====================================
function sZThemeNewsletterPage() {
	$context         = Timber::context();
	$timber_post     = new Timber\Post();
	$context['post'] = $timber_post;
	Timber::render( array( 'admin/adminNewsletterPage.twig' ), $context );
}


//====================================
// NEWSLETTER SETTINGS CREATION
//====================================
function sZThemeNewsletterSettings() {
	$newsletterGroup = 'sZTheme-newsletterSettings-group';
	$page = 'sZThemeNewsletter';

	// HEADER NEWSLETTER SECTION
	addSectionWithFields('hdrNewsletterSection', 'Newsletter header options', 'sZThemeHeaderNewsletterSection',
	                     $page, $newsletterGroup,
	                     ['hdrNewsletterH1'],
	                     ['hdrNewsletterH1'],
	                     ['Header'],
	                     ['sZThemeHdrNewsletterH1']);

	// FOOTER NEWSLETTER SECTION
	addSectionWithFields('footerNewsletterSection', 'Newsletter footer options', 'sZThemeFooterNewsletterSection',
	                     $page, $newsletterGroup,
	                     ['footerNewsletterH1', 'footerNewsletterH2', 'footerNewsletterDesc'],
	                     ['footerNewsletterH1', 'footerNewsletterH2', 'footerNewsletterDesc'],
	                     ['Header', 'SubHeader', 'Description'],
	                     ['sZThemeFooterNewsletterH1', 'sZThemeFooterNewsletterH2', 'sZThemeFooterNewsletterDesc']);
}


//====================================
// SECTIONS
//====================================
function sZThemeHeaderNewsletterSection() {}

function sZThemeFooterNewsletterSection() {}


//====================================
// FIELDS
//====================================
function sZThemeHdrNewsletterH1() {
	$optionName = 'hdrNewsletterH1';
	$optionValue = esc_attr( get_option($optionName));
	echo '<input type="text" maxlength="80" size=90 name="' . $optionName . '" value="' . $optionValue . '" placeholder="Header text">
			<p class="description">Maximum 80 chars!</p>';
}

function sZThemeFooterNewsletterH1() {
	$optionName = 'footerNewsletterH1';
	$optionValue = esc_attr( get_option($optionName));
	echo '<input type="text" name="' . $optionName . '" value="' . $optionValue . '" placeholder="H1 text"><br>';
}

function sZThemeFooterNewsletterH2() {
	$optionName = 'footerNewsletterH2';
	$optionValue = esc_attr( get_option($optionName));
	echo '<input type="text" name="' . $optionName . '" value="' . $optionValue . '" placeholder="H2 text"><br>';
}

function sZThemeFooterNewsletterDesc() {
	$optionName = 'footerNewsletterDesc';
	$optionValue = esc_attr( get_option( $optionName ) );
	echo '<input type="text" name="' . $optionName . '" value="' . $optionValue . '" placeholder="Desc text"><br>';
}