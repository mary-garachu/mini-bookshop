<?php

// Load CPT definitions
require_once get_stylesheet_directory() . '/inc/cpt-book.php';

// Enqueue parent and child theme styles
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['parent-style']
    );
});

require_once get_stylesheet_directory() . '/import-books.php';
