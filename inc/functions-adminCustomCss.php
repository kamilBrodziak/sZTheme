<?php

function sZThemeCustomCssPage() {
	$context         = Timber::context();
	$timber_post     = new Timber\Post();
	$context['post'] = $timber_post;
	Timber::render( array( 'admin/adminCustomCssPage.twig' ), $context );
}