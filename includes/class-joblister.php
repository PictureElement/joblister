<?php

/**
 * Plugin name: JobLister
 * Description: Simple job listing plugin to manage job openings on your WordPress site.
 * Author: Marios Sofokleous
 * Author URI: https://www.msof.me
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if (!class_exists('JobLister')) {
  class JobLister
  {

    // Constructor
    public function __construct()
    {
      add_action('plugins_loaded', array($this, 'init'));
    }

    // Initialization method
    public function init()
    {
      $this->load_dependencies();
    }

    // Load dependencies
    private function load_dependencies()
    {
      require_once plugin_dir_path(__FILE__) . '/class-joblister-dependencies.php';
      require_once plugin_dir_path(__FILE__) . '/class-joblister-scripts.php';
      require_once plugin_dir_path(__FILE__) . '/class-joblister-styles.php';
      require_once plugin_dir_path(__FILE__) . '/class-joblister-shortcodes.php';
      require_once plugin_dir_path(__FILE__) . '/class-joblister-custom-post-types.php';
      require_once plugin_dir_path(__FILE__) . '/class-joblister-custom-taxonomies.php';
      require_once plugin_dir_path(__FILE__) . '/class-joblister-rest-api.php';
      require_once plugin_dir_path(__FILE__) . '/class-joblister-meta-boxes.php';
      require_once plugin_dir_path(__FILE__) . '/class-joblister-admin-columns.php';
    }
  }
}
