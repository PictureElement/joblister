<?php

// If this file is access directly, abort!
defined('ABSPATH') or die('Unauthorized Access');

// Register style
function jl_register_style() {
  // Do not enqueue here. Load in demand, enqueue in shortcode.
  wp_register_style(
    'jl-style',
    plugin_dir_url(__DIR__) . '/build/index.css',
    [],
    rand(),
    'all'
  );
}
add_action('wp_enqueue_scripts', 'jl_register_style');
