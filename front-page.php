<?php
$context = Timber::context();
$context['post'] = new Timber\Post();
$templates = array( 'index.twig' );
if ( is_home() || is_front_page()) {
    array_unshift( $templates, 'front-page.twig', 'home.twig' );
}
Timber::render( $templates, $context );