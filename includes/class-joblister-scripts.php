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
    $options = get_option('joblister_options');
    $data = array(
      'restBaseUrl' => rest_url(),
      'perPage' => !empty($options['per_page']) ? $options['per_page'] : '10',
      'wordpressUsername' => isset($options['wordpress_username']) ? $options['wordpress_username'] : '',
      'applicationPassword' => isset($options['application_password']) ? $options['application_password'] : '',
      'captchaSiteKey' => !empty($options['captcha_site_key']) ? $options['captcha_site_key'] : '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
    );
    wp_localize_script('jl-script', 'jlData', $data);
  }
}
