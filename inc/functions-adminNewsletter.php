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
	                     ['hdrNewsletterActionLink', 'hdrNewsletterH1'],
	                     ['hdrNewsletterActionLink', 'hdrNewsletterH1'],
	                     ['Action', 'Header'],
	                     ['sZThemeHdrNewsletterActionLink', 'sZThemeHdrNewsletterH1']);

	// FOOTER NEWSLETTER SECTION
	addSectionWithFields('footerNewsletterSection', 'Newsletter footer options', 'sZThemeFooterNewsletterSection',
	                     $page, $newsletterGroup,
	                     ['footerNewsletterActionLink', 'footerNewsletterH1', 'footerNewsletterH2', 'footerNewsletterDesc'],
	                     ['footerNewsletterActionLink', 'footerNewsletterH1', 'footerNewsletterH2', 'footerNewsletterDesc'],
	                     ['Action', 'Header', 'SubHeader', 'Description'],
	                     ['sZThemeFooterNewsletterActionLink', 'sZThemeFooterNewsletterH1', 'sZThemeFooterNewsletterH2', 'sZThemeFooterNewsletterDesc']);
}


//====================================
// SECTIONS
//====================================
function sZThemeHeaderNewsletterSection() {}

function sZThemeFooterNewsletterSection() {}


//====================================
// FIELDS
//====================================

// HEADER SECTION FIELDS
function sZThemeHdrNewsletterActionLink() {
	$optionName = 'hdrNewsletterActionLink';
	$optionValue = esc_attr( get_option($optionName));
	echo '<input type="text" size=90 name="' . $optionName . '" value="' . $optionValue . '" placeholder="Header newsletter action link">';
}

function sZThemeHdrNewsletterH1() {
	$optionName = 'hdrNewsletterH1';
	$optionValue = esc_attr( get_option($optionName));
	echo '<input type="text" maxlength="80" size=90 name="' . $optionName . '" value="' . $optionValue . '" placeholder="Header text">
			<p class="description">Maximum 80 chars!</p>';
}

// FOOTER SECTION FIELDS
function sZThemeFooterNewsletterActionLink() {
	$optionName = 'footerNewsletterActionLink';
	$optionValue = esc_attr( get_option($optionName));
	echo '<input type="text" size=90 name="' . $optionName . '" value="' . $optionValue . '" placeholder="Footer newsletter action link">';
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