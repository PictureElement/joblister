<?php
/*
 * Plugin Name:       JobLister
 * Requires Plugins:  radio-buttons-for-taxonomies
 * Plugin URI:        https://github.com/PictureElement/joblister
 * Description:       React-powered job listing made simple for WordPress.
 * Version:           1.3.0
 * Author:            Marios Sofokleous
 * Author URI:        https://www.msof.me/
 * License:           GPL-3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.en.html
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define('JBLS_PLUGIN_FILE', __FILE__);

// Include core class file
require_once plugin_dir_path(__FILE__) . 'includes/class-jbls.php';
// Include custom post types class
require_once plugin_dir_path(__FILE__) . 'includes/class-jbls-post-types.php';
// Include custom taxonomies class
require_once plugin_dir_path(__FILE__) . 'includes/class-jbls-taxonomies.php';

// Initialize the JobLister plugin
new JBLS();

// Activation hook
function jbls_plugin_activation() {
  // Initialize custom post types
  $jbls_post_types = new JBLS_Post_Types();
  $jbls_post_types->jbls_init();
  
  // Initialize custom taxonomies
  $jbls_taxonomies = new JBLS_Taxonomies();
  $jbls_taxonomies->jbls_init();

  // Clear the permalinks after the post type has been registered.
  flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'jbls_plugin_activation' );

// Deactivation hook
function jbls_plugin_deactivation() {
  // Unregister the post types, so the rules are no longer in memory.
  unregister_post_type('jbls_job');
  unregister_post_type('jbls_application');

  // Unregister the taxonomies, so the rules are no longer in memory.
  unregister_taxonomy('jbls_location');
  unregister_taxonomy('jbls_category');
  unregister_taxonomy('jbls_type');
  unregister_taxonomy('jbls_experience_level');

  // Clear the permalinks to remove our post type's rules from the database.
  flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'jbls_plugin_deactivation');
