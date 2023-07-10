<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JL_Styles
{
  // Constructor
  public function __construct()
  {
    add_action('wp_enqueue_scripts', array($this, 'register_style'));
  }

  // Register style
  public function register_style()
  {
    // Do not enqueue here. Load on demand, enqueue in shortcode.
    wp_register_style(
      'jl-style', // Name of the style
      plugin_dir_url(__DIR__) . '/build/index.css', // Full URL of the style
      [], // Dependencies
      rand(), // Style version number (Change this to null for production)
      'all' // Media
    );
  }
}

// Initialize the JL_Styles
new JL_Styles();
