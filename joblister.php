<?php

/**
 * Plugin name: JobLister
 * Description: Simple job listing plugin to manage job openings on your WordPress site.
 * Author: Marios Sofokleous
 * Author URI: https://www.msof.me
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if (!class_exists('JobLister_Plugin')) {
  class JobLister_Plugin
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
      require_once plugin_dir_path(__FILE__) . 'includes/class-jl-dependencies.php';
      require_once plugin_dir_path(__FILE__) . 'includes/class-jl-scripts.php';
      require_once plugin_dir_path(__FILE__) . 'includes/class-jl-styles.php';
      require_once plugin_dir_path(__FILE__) . 'includes/class-jl-shortcodes.php';
      require_once plugin_dir_path(__FILE__) . 'includes/class-jl-custom-post-types.php';
      require_once plugin_dir_path(__FILE__) . 'includes/class-jl-custom-taxonomies.php';
      require_once plugin_dir_path(__FILE__) . 'includes/class-jl-rest-api.php';
      require_once plugin_dir_path(__FILE__) . 'includes/class-jl-meta-boxes.php';
      require_once plugin_dir_path(__FILE__) . 'includes/class-jl-admin-columns.php';
    }
  }
}

// Initialize the JobLister plugin
new JobLister_Plugin();
