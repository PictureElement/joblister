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

    // Localize the script with Settings page data
    $options = get_option('jl_options');

    // If the permalink structure is empty, it means WordPress is using "Plain" permalinks,
    // and we should use "&" to append query parameters to the URL.
    // Otherwise, we can use "?".
    $permalink_structure = get_option('permalink_structure');
    $separator = empty($permalink_structure) ? '&' : '?';

    $data = array(
      'restBaseUrl' => rest_url(),
      'perPage' => $options['jl_per_page'],
      'wordpressUsername' => $options['jl_wordpress_username'],
      'applicationPassword' => $options['jl_application_password'],
      'captchaSiteKey' => $options['jl_captcha_site_key'],
      'privacyLink' => $options['jl_privacy_link'],
      'separator' => $separator,
    );
    wp_localize_script('jl-script', 'jlData', $data);
  }
}
