<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JBLS_Styles
{
  // Constructor
  public function __construct()
  {
    add_action('wp_enqueue_scripts', array($this, 'jbls_register_style'));
  }

  // Register style
  public function jbls_register_style()
  {
    // Do not enqueue here. Load on demand, enqueue in shortcode.
    wp_register_style(
      'jbls-style', // Name of the style
      plugin_dir_url(__DIR__) . '/build/index.css', // Full URL of the style
      [], // Dependencies
      rand(), // Style version number (Change this to null for production)
      'all' // Media
    );

    // Add custom styles to the registered style
    $this->jbls_add_styles_to_registered_style();
  }

  public function jbls_add_styles_to_registered_style()
  {
    // Get options
    $options = get_option('jbls_options', [
      'jbls_google_font_link' => '',
      'jbls_google_font_family' => '',
      'jbls_accent' => '#1a73e8',
      'jbls_on_accent' => '#ffffff',
      'jbls_background' => '#f8f9fa',
      'jbls_on_background_primary' => '#202124',
      'jbls_on_background_secondary' => '#5f6368',
      'jbls_on_background_border' => '#dadce0',
      'jbls_surface' => '#ffffff',
      'jbls_on_surface_primary' => '#202124',
      'jbls_on_surface_secondary' => '#5f6368',
      'jbls_on_surface_border' => '#dadce0',
      'jbls_error' => '#dc3545',
      'jbls_success' => '#198754'
    ]);

    // Check if the Google Font Link and Google Font Family are set and not empty
    if (!empty($options['jbls_google_font_link']) && !empty($options['jbls_google_font_family'])) {
        // Add the @import statement to custom_css
        $custom_css = "
          @import url('{$options['jbls_google_font_link']}');
          :root {
            --jbls-family: {$options['jbls_google_font_family']};
            --jbls-accent: {$options['jbls_accent']};
            --jbls-on-accent: {$options['jbls_on_accent']};
            --jbls-background: {$options['jbls_background']};
            --jbls-on-background-primary: {$options['jbls_on_background_primary']};
            --jbls-on-background-secondary: {$options['jbls_on_background_secondary']};
            --jbls-on-background-border: {$options['jbls_on_background_border']};
            --jbls-surface: {$options['jbls_surface']};
            --jbls-on-surface-primary: {$options['jbls_on_surface_primary']};
            --jbls-on-surface-secondary: {$options['jbls_on_surface_secondary']};
            --jbls-on-surface-border: {$options['jbls_on_surface_border']};
            --jbls-error: {$options['jbls_error']};
            --jbls-success: {$options['jbls_success']};
          }
        ";
    } else {
      $custom_css = "
        :root {
          --jbls-family: inherit;
          --jbls-accent: {$options['jbls_accent']};
          --jbls-on-accent: {$options['jbls_on_accent']};
          --jbls-background: {$options['jbls_background']};
          --jbls-on-background-primary: {$options['jbls_on_background_primary']};
          --jbls-on-background-secondary: {$options['jbls_on_background_secondary']};
          --jbls-on-background-border: {$options['jbls_on_background_border']};
          --jbls-surface: {$options['jbls_surface']};
          --jbls-on-surface-primary: {$options['jbls_on_surface_primary']};
          --jbls-on-surface-secondary: {$options['jbls_on_surface_secondary']};
          --jbls-on-surface-border: {$options['jbls_on_surface_border']};
          --jbls-error: {$options['jbls_error']};
          --jbls-success: {$options['jbls_success']};
        }
      ";
    }

    wp_add_inline_style('jbls-style', $custom_css);
  }
}
