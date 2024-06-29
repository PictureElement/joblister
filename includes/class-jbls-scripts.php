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
      wp_rand(), // Script version number (Change this to null for production)
      true // Enqueue script before </body>
    );

    // Define default values for the settings
    $defaults = [
      'jbls_per_page' => 10,
      'jbls_captcha_site_key' => '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
      'jbls_privacy_url' => '/privacy-policy/',
    ];

    // Get options
    $options = get_option('jbls_options', $defaults);

    $general_options = [];

    foreach ($defaults as $key => $default) {
      if (!empty($options[$key])) {
        $general_options[$key] = $options[$key];
      } else {
        $general_options[$key] = $default;
      }
    }
    
    // If the permalink structure is empty, it means WordPress is using "Plain" permalinks,
    // and we should use "&" to append query parameters to the URL.
    // Otherwise, we can use "?".
    $permalink_structure = get_option('permalink_structure');
    $separator = empty($permalink_structure) ? '&' : '?';

    $data = array(
      'nonce' => wp_create_nonce('wp_rest'),
      'restBaseUrl' => rest_url(),
      'perPage' => $general_options['jbls_per_page'],
      'captchaSiteKey' => $general_options['jbls_captcha_site_key'],
      'privacyUrl' => $general_options['jbls_privacy_url'],
      'separator' => $separator,
    );

    // Localize the script
    wp_localize_script('jbls-script', 'jblsData', $data);
  }
}
