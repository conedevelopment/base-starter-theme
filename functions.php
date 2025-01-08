<?php

// Pull in the autoloader
require __DIR__.'/autoload.php';

// Boot the theme
Base\Theme::boot();

/**
 * Imports
 */
require __DIR__ . '/inc/template-functions.php';
require __DIR__ . '/inc/template-tags.php';
