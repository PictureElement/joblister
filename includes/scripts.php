<?php

// If this file is access directly, abort!
defined('ABSPATH') or die('Unauthorized Access');

// Register script
function jl_register_script() {
  // Do not enqueue here. Load in demand, enqueue in shortcode.
  wp_register_script(
    'jl-script', // Name of the script
    plugin_dir_url(__DIR__) . '/build/index.js', // Full URL of the script
    ['wp-element'], // Dependencies
    rand(), // Script version number (Change this to null for production)
    true // Enqueue script before </body>
  );
}
add_action('wp_enqueue_scripts', 'jl_register_script');