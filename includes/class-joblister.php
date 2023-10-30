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
      $joblister_dependencies = new Joblister_Dependencies();
      $joblister_scripts = new Joblister_Scripts();
      $joblister_styles = new Joblister_Styles();
      $joblister_shortcodes = new Joblister_Shortcodes();
      $joblister_custom_post_types = new JL_Custom_Post_Types();
      $joblister_custom_taxonomies = new Joblister_Custom_Taxonomies();
      $joblister_rest_api = new Joblister_REST_API();
      $joblister_meta_boxes = new Joblister_Meta_Boxes();
      $joblister_admin_columns = new JL_Admin_Columns();
    }
  }
}
