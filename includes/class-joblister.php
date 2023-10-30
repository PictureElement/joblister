<?php

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
      $this->initialize_classes();
    }

    // Load dependencies
    private function load_dependencies()
    {
      require_once plugin_dir_path(__FILE__) . '/class-joblister-settings.php';
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

    // Initialize classes
    private function initialize_classes()
    {
      $joblister_settings = new JL_Settings();
      $joblister_dependencies = new JL_Dependencies();
      $joblister_scripts = new JL_Scripts();
      $joblister_styles = new JL_Styles();
      $joblister_shortcodes = new JL_Shortcodes();
      $joblister_custom_post_types = new JL_Custom_Post_Types();
      $joblister_custom_taxonomies = new JL_Custom_Taxonomies();
      $joblister_rest_api = new JL_REST_API();
      $joblister_meta_boxes = new JL_Meta_Boxes();
      $joblister_admin_columns = new JL_Admin_Columns();
    }
  }
}
