<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JBLS_Scripts
{
  // Constructor
  public function __construct()
  {
    add_action('wp_enqueue_scripts', array($this, 'jbls_register_script'));
  }

  // Register script
  public function jbls_register_script()
  {
    // Do not enqueue here. Load on demand, enqueue in shortcode.
    wp_register_script(
      'jbls-script', // Name of the script
      plugin_dir_url(__DIR__) . '/build/index.js', // Full URL of the script
      ['wp-element'], // Dependencies
      rand(), // Script version number (Change this to null for production)
      true // Enqueue script before </body>
    );

    // Localize the script with Settings page data
    $options = get_option('jbls_options');

    // If the permalink structure is empty, it means WordPress is using "Plain" permalinks,
    // and we should use "&" to append query parameters to the URL.
    // Otherwise, we can use "?".
    $permalink_structure = get_option('permalink_structure');
    $separator = empty($permalink_structure) ? '&' : '?';

    $data = array(
      'restBaseUrl' => rest_url(),
      'perPage' => $options['jbls_per_page'],
      'wordpressUsername' => $options['jbls_wordpress_username'],
      'applicationPassword' => $options['jbls_application_password'],
      'captchaSiteKey' => $options['jbls_captcha_site_key'],
      'privacyLink' => $options['jbls_privacy_link'],
      'separator' => $separator,
    );
    wp_localize_script('jbls-script', 'jblsData', $data);
  }
}
