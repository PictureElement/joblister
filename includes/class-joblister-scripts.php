<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JL_Scripts
{
  // Constructor
  public function __construct()
  {
    add_action('wp_enqueue_scripts', array($this, 'register_script'));
  }

  // Register script
  public function register_script()
  {
    // Do not enqueue here. Load on demand, enqueue in shortcode.
    wp_register_script(
      'jl-script', // Name of the script
      plugin_dir_url(__DIR__) . '/build/index.js', // Full URL of the script
      ['wp-element'], // Dependencies
      rand(), // Script version number (Change this to null for production)
      true // Enqueue script before </body>
    );
  }
}
