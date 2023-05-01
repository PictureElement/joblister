<?php

/**
 * Plugin name: Msof Jobs
 * Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Author: Marios Sofokleous
 */

// 01. If this file is access directly, abort!
defined('ABSPATH') or die('Unauthorized Access');

// 02. Handle plugin dependencies
function msof_jobs_handle_plugin_dependencies() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'radio-buttons-for-taxonomies/radio-buttons-for-taxonomies.php' ) ) {
        add_action( 'admin_notices', 'msof_jobs_plugin_notice' );

        deactivate_plugins( plugin_basename( __FILE__ ) ); 

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}
function msof_jobs_plugin_notice() {
  echo '<div class="error"><p>Sorry, but <strong>Msof Jobs</strong> plugin requires the <strong>Radio Buttons for Taxonomies</strong> plugin to be installed and active.</p></div>';
}
add_action( 'admin_init', 'msof_jobs_handle_plugin_dependencies' );

// 03. Register shortcode
function msof_jobs_shortcode()
{
  // Enqueue scripts and styles
  wp_enqueue_script('msof-jobs-script');
  wp_enqueue_style('msof-jobs-style');

  return '<div class="msof-jobs-root" id="msofJobsRoot"></div>';
}
add_shortcode('msof_jobs', 'msof_jobs_shortcode');

// 04. Register script
function msof_jobs_register_script()
{
  // Do not enqueue here. Load in demand, enqueue in shortcode.
  wp_register_script(
    'msof-jobs-script', // Name of the script
    plugin_dir_url(__FILE__) . '/build/index.js', // Full URL of the script
    ['wp-element'], // Dependencies
    rand(), // Script version number (Change this to null for production)
    true // Enqueue script before </body>
  );
}
add_action('wp_enqueue_scripts', 'msof_jobs_register_script');

// 05. Register style
function msof_jobs_register_style()
{
  // Do not enqueue here. Load in demand, enqueue in shortcode.
  wp_register_style(
    'msof-jobs-style',
    plugin_dir_url(__FILE__) . '/build/index.css',
    [],
    rand(),
    'all'
  );
}
add_action('wp_enqueue_scripts', 'msof_jobs_register_style');

// 06. Register "msof_job" post type
function register_cpt_msof_job()
{

  $labels = [
    "name" => "Jobs",
    "singular_name" => "Job",
    "menu_name" => "Jobs",
    "all_items" => "All Jobs",
    "add_new" => "Add new",
    "add_new_item" => "Add new Job",
    "edit_item" => "Edit Job",
    "new_item" => "New Job",
    "view_item" => "View Job",
    "view_items" => "View Jobs",
    "search_items" => "Search Jobs",
    "not_found" => "No Jobs found",
    "not_found_in_trash" => "No Jobs found in trash",
    "parent" => "Parent Job:",
    "featured_image" => "Featured image for this Job",
    "set_featured_image" => "Set featured image for this Job",
    "remove_featured_image" => "Remove featured image for this Job",
    "use_featured_image" => "Use as featured image for this Job",
    "archives" => "Job archives",
    "insert_into_item" => "Insert into Job",
    "uploaded_to_this_item" => "Upload to this Job",
    "filter_items_list" => "Filter Jobs list",
    "items_list_navigation" => "Jobs list navigation",
    "items_list" => "Jobs list",
    "attributes" => "Jobs attributes",
    "name_admin_bar" => "Job",
    "item_published" => "Job published",
    "item_published_privately" => "Job published privately.",
    "item_reverted_to_draft" => "Job reverted to draft.",
    "item_scheduled" => "Job scheduled",
    "item_updated" => "Job updated.",
    "parent_item_colon" => "Parent Job:",
  ];

  $args = [
    "label" => "Jobs",
    "labels" => $labels,
    "description" => "",
    "public" => false,
    "publicly_queryable" => false,
    "show_ui" => true,
    "show_in_rest" => true,
    "rest_base" => "msof-jobs",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => true,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "can_export" => true,
    "rewrite" => false,
    "query_var" => true,
    "supports" => ["title"],
    "show_in_graphql" => false
  ];

  register_post_type("msof_job", $args);
}
add_action('init', 'register_cpt_msof_job');

// 07. Register "msof_job_location" taxonomy
function register_msof_job_location()
{

  $labels = [
    "name" => "Locations",
    "singular_name" => "Location",
    "menu_name" => "Locations",
    "all_items" => "All Locations",
    "edit_item" => "Edit Location",
    "view_item" => "View Location",
    "update_item" => "Update Location name",
    "add_new_item" => "Add new Location",
    "new_item_name" => "New Location name",
    "parent_item" => "Parent Location",
    "parent_item_colon" => "Parent Location:",
    "search_items" => "Search Locations",
    "popular_items" => "Popular Locations",
    "separate_items_with_commas" => "Separate Locations with commas",
    "add_or_remove_items" => "Add or remove Locations",
    "choose_from_most_used" => "Choose from the most used Locations",
    "not_found" => "No Locations found",
    "no_terms" => "No Locations",
    "items_list_navigation" => "Locations list navigation",
    "items_list" => "Locations list",
    "back_to_items" => "Back to Locations",
    "name_field_description" => "The name is how it appears on your site.",
    "parent_field_description" => "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.",
    "slug_field_description" => "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.",
    "desc_field_description" => "The description is not prominent by default; however, some themes may show it.",
  ];

  $args = [
    "label" => "Locations",
    "labels" => $labels,
    "public" => false,
    "publicly_queryable" => false,
    "hierarchical" => false,
    "show_ui" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "query_var" => true,
    "rewrite" => false,
    "show_admin_column" => true,
    "show_in_rest" => true,
    "show_tagcloud" => false,
    "rest_base" => "msof-job-locations",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => true,
    "sort" => false,
    "show_in_graphql" => false,
  ];
  register_taxonomy("msof_job_location", array( 'msof_job' ), $args);
}
add_action('init', 'register_msof_job_location');
// Disable the "No term" option on the "msof_job_location" taxonomy
add_filter( "radio_buttons_for_taxonomies_no_term_msof_job_location", "__return_FALSE" );

// 08. Register "msof_job_category" taxonomy
function register_msof_job_category()
{

  $labels = [
    "name" => "Categories",
    "singular_name" => "Category",
    "menu_name" => "Categories",
    "all_items" => "All Categories",
    "edit_item" => "Edit Category",
    "view_item" => "View Category",
    "update_item" => "Update Category name",
    "add_new_item" => "Add new Category",
    "new_item_name" => "New Category name",
    "parent_item" => "Parent Category",
    "parent_item_colon" => "Parent Category:",
    "search_items" => "Search Categories",
    "popular_items" => "Popular Categories",
    "separate_items_with_commas" => "Separate Categories with commas",
    "add_or_remove_items" => "Add or remove Categories",
    "choose_from_most_used" => "Choose from the most used Categories",
    "not_found" => "No Categories found",
    "no_terms" => "No Categories",
    "items_list_navigation" => "Categories list navigation",
    "items_list" => "Categories list",
    "back_to_items" => "Back to Categories",
    "name_field_description" => "The name is how it appears on your site.",
    "parent_field_description" => "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.",
    "slug_field_description" => "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.",
    "desc_field_description" => "The description is not prominent by default; however, some themes may show it.",
  ];

  $args = [
    "label" => "Categories",
    "labels" => $labels,
    "public" => false,
    "publicly_queryable" => false,
    "hierarchical" => false,
    "show_ui" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "query_var" => true,
    "rewrite" => false,
    "show_admin_column" => true,
    "show_in_rest" => true,
    "show_tagcloud" => false,
    "rest_base" => "msof-job-categories",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => true,
    "sort" => false,
    "show_in_graphql" => false,
  ];
  register_taxonomy("msof_job_category", ["msof_job"], $args);
}
add_action('init', 'register_msof_job_category');
// Disable the "No term" option on the "msof_job_location" taxonomy
add_filter( "radio_buttons_for_taxonomies_no_term_msof_job_category", "__return_FALSE" );