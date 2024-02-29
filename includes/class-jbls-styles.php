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
      wp_rand(), // Style version number (Change this to null for production)
      'all' // Media
    );

    // Add custom styles to the registered style
    $this->jbls_add_styles_to_registered_style();
  }

  public function jbls_add_styles_to_registered_style()
  {
    // Define default values for the settings
    $defaults = [
      'jbls_google_font_family' => 'inherit',
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
    ];

    // Fetch options. If not set, use an empty array as fallback
    $options = get_option('jbls_options', []);

    // Include Google font import if jbls_google_font_url is set and not empty.
    $custom_css = !empty($options['jbls_google_font_url'])
                  ? "@import url('{$options['jbls_google_font_url']}');\n"
                  : '';

    $style_options = [];

    foreach ($defaults as $key => $default) {
      if (!empty($options[$key])) {
        $style_options[$key] = $options[$key];
      } else {
        $style_options[$key] = $default;
      }
    }

    $custom_css .= ":root {\n";

    // Loop through each option and add to CSS
    foreach ($style_options as $key => $value) {
      $css_var_name = str_replace(['jbls_', '_'], ['--jbls-', '-'], $key);
      $custom_css .= "  {$css_var_name}: {$value};\n";
    }
  
    $custom_css .= "}";
    
    // Add custom CSS to the registered style
    wp_add_inline_style('jbls-style', $custom_css);
  }
}
