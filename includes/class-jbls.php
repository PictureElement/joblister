<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path(__FILE__) . '/class-jbls-settings.php';
require_once plugin_dir_path(__FILE__) . '/class-jbls-dependencies.php';
require_once plugin_dir_path(__FILE__) . '/class-jbls-scripts.php';
require_once plugin_dir_path(__FILE__) . '/class-jbls-styles.php';
require_once plugin_dir_path(__FILE__) . '/class-jbls-shortcodes.php';
require_once plugin_dir_path(__FILE__) . '/class-jbls-post-types.php';
require_once plugin_dir_path(__FILE__) . '/class-jbls-taxonomies.php';
require_once plugin_dir_path(__FILE__) . '/class-jbls-rest.php';
require_once plugin_dir_path(__FILE__) . '/class-jbls-meta-boxes.php';
require_once plugin_dir_path(__FILE__) . '/class-jbls-admin-columns.php';

if (!class_exists('JBLS')) {
  class JBLS
  {
    // Constructor
    public function __construct()
    {
      add_action('plugins_loaded', array($this, 'jbls_init'));
    }

    // Initialization method
    public function jbls_init()
    {
      $this->jbls_initialize_classes();
    }

    // Initialize classes
    private function jbls_initialize_classes()
    {
      $jbls_settings = new JBLS_Settings();
      $jbls_dependencies = new JBLS_Dependencies();
      $jbls_scripts = new JBLS_Scripts();
      $jbls_styles = new JBLS_Styles();
      $jbls_shortcodes = new JBLS_Shortcodes();
      $jbls_custom_post_types = new JBLS_Post_Types();
      $jbls_custom_taxonomies = new JBLS_Taxonomies();
      $jbls_rest_api = new JBLS_REST();
      $jbls_meta_boxes = new JBLS_Meta_Boxes();
      $jbls_admin_columns = new JBLS_Admin_Columns();
    }
  }
}
