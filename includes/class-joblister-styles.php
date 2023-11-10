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
    $options = get_option('jl_options', [
      'jl_google_font_link' => '',
      'jl_google_font_family' => '',
      'jl_accent' => '#1a73e8',
      'jl_on_accent' => '#ffffff',
      'jl_background' => '#f8f9fa',
      'jl_on_background_primary' => '#202124',
      'jl_on_background_secondary' => '#5f6368',
      'jl_on_background_border' => '#dadce0',
      'jl_surface' => '#ffffff',
      'jl_on_surface_primary' => '#202124',
      'jl_on_surface_secondary' => '#5f6368',
      'jl_on_surface_border' => '#dadce0',
      'jl_error' => '#dc3545',
      'jl_success' => '#198754'
    ]);

    // Check if the Google Font Link and Google Font Family are set and not empty
    if (!empty($options['jl_google_font_link']) && !empty($options['jl_google_font_family'])) {
        // Add the @import statement to custom_css
        $custom_css = "
          @import url('{$options['jl_google_font_link']}');
          :root {
            --jl-family: {$options['jl_google_font_family']};
            --jl-accent: {$options['jl_accent']};
            --jl-on-accent: {$options['jl_on_accent']};
            --jl-background: {$options['jl_background']};
            --jl-on-background-primary: {$options['jl_on_background_primary']};
            --jl-on-background-secondary: {$options['jl_on_background_secondary']};
            --jl-on-background-border: {$options['jl_on_background_border']};
            --jl-surface: {$options['jl_surface']};
            --jl-on-surface-primary: {$options['jl_on_surface_primary']};
            --jl-on-surface-secondary: {$options['jl_on_surface_secondary']};
            --jl-on-surface-border: {$options['jl_on_surface_border']};
            --jl-error: {$options['jl_error']};
            --jl-success: {$options['jl_success']};
          }
        ";
    } else {
      $custom_css = "
        :root {
          --jl-family: inherit;
          --jl-accent: {$options['jl_accent']};
          --jl-on-accent: {$options['jl_on_accent']};
          --jl-background: {$options['jl_background']};
          --jl-on-background-primary: {$options['jl_on_background_primary']};
          --jl-on-background-secondary: {$options['jl_on_background_secondary']};
          --jl-on-background-border: {$options['jl_on_background_border']};
          --jl-surface: {$options['jl_surface']};
          --jl-on-surface-primary: {$options['jl_on_surface_primary']};
          --jl-on-surface-secondary: {$options['jl_on_surface_secondary']};
          --jl-on-surface-border: {$options['jl_on_surface_border']};
          --jl-error: {$options['jl_error']};
          --jl-success: {$options['jl_success']};
        }
      ";
    }

    wp_add_inline_style('jl-style', $custom_css);
  }
}
