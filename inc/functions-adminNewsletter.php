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
function sZThemeHdrNewsletterActionLinkOptionName() {
	return 'hdrNewsletterActionLink';
}

function sZThemeHdrNewsletterActionLinkOptionValue() {
	return esc_attr( get_option(sZThemeHdrNewsletterActionLinkOptionName()));
}

function sZThemeHdrNewsletterActionLink() {
	echo generateHTMLElement("input" ,
		[
			'type' => 'text',
			'name' => sZThemeHdrNewsletterActionLinkOptionName(),
			'value' => sZThemeHdrNewsletterActionLinkOptionValue(),
			'size' => '100',
			'placeholder' => 'Header newsletter action link'
		]
	);
}

function sZThemeHdrNewsletterH1OptionName() {
	return 'hdrNewsletterH1';
}

function sZThemeHdrNewsletterH1OptionValue() {
	return esc_attr( get_option(sZThemeHdrNewsletterH1OptionName()));
}

function sZThemeHdrNewsletterH1() {
	echo generateHTMLElement("input" ,
		[
			'type' => 'text',
			'name' => sZThemeHdrNewsletterH1OptionName(),
			'value' => sZThemeHdrNewsletterH1OptionValue(),
			'size' => '100',
			'maxlength' => '80',
			'placeholder' => 'Header text'
		]
	);
	echo '<p class="description">Maximum 80 chars!</p>';
}

// FOOTER SECTION FIELDS
function sZThemeFooterNewsletterActionLinkOptionName() {
	return 'footerNewsletterActionLink';
}

function sZThemeFooterNewsletterActionLinkOptionValue() {
	return esc_attr( get_option(sZThemeFooterNewsletterActionLinkOptionName()));
}

function sZThemeFooterNewsletterActionLink() {
	echo generateHTMLElement("input" ,
		[
			'type' => 'text',
			'name' => sZThemeFooterNewsletterActionLinkOptionName(),
			'value' => sZThemeFooterNewsletterActionLinkOptionValue(),
			'size' => '100',
			'placeholder' => 'Footer newsletter action link'
		]
	);
}

function sZThemeFooterNewsletterH1OptionName() {
	return 'footerNewsletterH1';
}

function sZThemeFooterNewsletterH1OptionValue() {
	return esc_attr( get_option(sZThemeFooterNewsletterH1OptionName()));
}

function sZThemeFooterNewsletterH1() {
	echo generateHTMLElement("input" ,
		[
			'type' => 'text',
			'name' => sZThemeFooterNewsletterH1OptionName(),
			'value' => sZThemeFooterNewsletterH1OptionValue(),
			'size' => '100',
			'placeholder' => 'Header text'
		]
	);
}

function sZThemeFooterNewsletterH2OptionName() {
	return 'footerNewsletterH2';
}

function sZThemeFooterNewsletterH2OptionValue() {
	return esc_attr( get_option(sZThemeFooterNewsletterH2OptionName()));
}

function sZThemeFooterNewsletterH2() {
	echo generateHTMLElement("input" ,
         [
             'type' => 'text',
             'name' => sZThemeFooterNewsletterH2OptionName(),
             'value' => sZThemeFooterNewsletterH2OptionValue(),
             'size' => '100',
             'placeholder' => 'Subheader text'
         ]
	);
}

function sZThemeFooterNewsletterDescOptionName() {
	return 'footerNewsletterDesc';
}

function sZThemeFooterNewsletterDescOptionValue() {
	return esc_attr( get_option(sZThemeFooterNewsletterDescOptionName()));
}

function sZThemeFooterNewsletterDesc() {
	echo generateHTMLElement("textarea" ,
         [
             'name' => sZThemeFooterNewsletterDescOptionName(),
             'cols' => '100',
             'rows' => '5',
             'placeholder' => 'Description text'
         ], false, sZThemeFooterNewsletterDescOptionValue()
	);
}