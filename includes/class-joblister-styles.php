<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JL_Styles
{
  // Constructor
  public function __construct()
  {
    add_action('wp_enqueue_scripts', array($this, 'register_style'));
    add_action('wp_enqueue_scripts', array($this, 'add_styles_to_registered_style'));
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

    // Add custom styles to the registered style
    $this->add_styles_to_registered_style();
  }

  public function add_styles_to_registered_style()
  {
    // Get options
    $options = get_option('joblister_options');

    $accent = $options['accent'];
    $on_accent = $options['on_accent'];

    $custom_css = "
      :root {
        --jl-accent: {$accent};
        --jl-on-accent: {$on_accent};
      }
    ";

    wp_add_inline_style('jl-style', $custom_css);
  }
}
