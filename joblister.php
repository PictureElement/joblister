<?php
/*
 * Plugin Name:       JobLister
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       React-powered job listing made simple for WordPress.
 * Version:           1.0.0
 * Author:            Marios Sofokleous
 * Author URI:        https://www.msof.me/
 * License:           GNU General Public License v3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.en.html
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Include core class file
require_once plugin_dir_path(__FILE__) . 'includes/class-joblister.php';

// Initialize the JobLister plugin
new JobLister();

// Activation hook
function joblister_activation() { 
  // Load and initialize custom post types class
  require_once plugin_dir_path(__FILE__) . 'includes/class-joblister-custom-post-types.php';
  $joblister_custom_post_types = new JL_Custom_Post_Types();

  // Trigger custom post types registration
  $joblister_custom_post_types->register_cpt_jl_job();
  $joblister_custom_post_types->register_cpt_jl_application();

  // Load and initialize custom taxonomies class
  require_once plugin_dir_path(__FILE__) . 'includes/class-joblister-custom-taxonomies.php';
  $joblister_custom_taxonomies = new JL_Custom_Taxonomies();

  // Trigger custom taxonomies registration
  $joblister_custom_taxonomies->register_jl_location();
  $joblister_custom_taxonomies->register_jl_category();
  $joblister_custom_taxonomies->register_jl_type();
  $joblister_custom_taxonomies->register_jl_experience_level();

  // Clear the permalinks after the post type has been registered.
  flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'joblister_activation' );

// Deactivation hook
function joblister_deactivation() {
  // Unregister the post types, so the rules are no longer in memory.
  unregister_post_type('jl_job');
  unregister_post_type('jl_application');

  // Unregister the taxonomies, so the rules are no longer in memory.
  unregister_taxonomy('jl_location');
  unregister_taxonomy('jl_category');
  unregister_taxonomy('jl_type');
  unregister_taxonomy('jl_experience_level');

  // Clear the permalinks to remove our post type's rules from the database.
  flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'joblister_deactivation');
