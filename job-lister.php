<?php

/**
 * Plugin name: JobLister
 * Description: Simple job listing plugin to manage job openings on your WordPress site.
 * Author: Marios Sofokleous
 * Author URI: https://www.msof.me
 */

// 01. If this file is access directly, abort!
defined('ABSPATH') or die('Unauthorized Access');

// 02. Handle plugin dependencies
function JL_handle_plugin_dependencies() {
  if (is_admin() && current_user_can('activate_plugins') &&  !is_plugin_active('radio-buttons-for-taxonomies/radio-buttons-for-taxonomies.php')) {
    add_action('admin_notices', 'JL_plugin_notice');

    deactivate_plugins(plugin_basename(__FILE__));

    if (isset($_GET['activate'])) {
      unset($_GET['activate']);
    }
  }
}
function JL_plugin_notice() {
  echo '<div class="error"><p>Sorry, but <strong>JobLister</strong> plugin requires the <strong>Radio Buttons for Taxonomies</strong> plugin to be installed and active.</p></div>';
}
add_action('admin_init', 'JL_handle_plugin_dependencies');

// 03. Register shortcode
function JL_shortcode() {
  // Enqueue scripts and styles
  wp_enqueue_script('jl-script');
  wp_enqueue_style('jl-style');

  return '<div class="jl-root" id="jlRoot"></div>';
}
add_shortcode('joblister', 'JL_shortcode');

// 04. Register script
function JL_register_script() {
  // Do not enqueue here. Load in demand, enqueue in shortcode.
  wp_register_script(
    'jl-script', // Name of the script
    plugin_dir_url(__FILE__) . '/build/index.js', // Full URL of the script
    ['wp-element'], // Dependencies
    rand(), // Script version number (Change this to null for production)
    true // Enqueue script before </body>
  );
}
add_action('wp_enqueue_scripts', 'JL_register_script');

// 05. Register style
function JL_register_style() {
  // Do not enqueue here. Load in demand, enqueue in shortcode.
  wp_register_style(
    'jl-style',
    plugin_dir_url(__FILE__) . '/build/index.css',
    [],
    rand(),
    'all'
  );
}
add_action('wp_enqueue_scripts', 'JL_register_style');

// 06. Register "jl_job" post type
function JL_register_cpt_jl_job() {

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
    "rest_base" => "jl-jobs",
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
    "supports" => ["title", "editor"],
    "show_in_graphql" => false
  ];

  register_post_type("jl_job", $args);
}
add_action('init', 'JL_register_cpt_jl_job');

// 07. Register "jl_location" taxonomy
function JL_register_jl_location() {

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
    "rest_base" => "jl-locations",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => true,
    "sort" => false,
    "show_in_graphql" => false,
  ];
  register_taxonomy("jl_location", array('jl_job'), $args);
}
add_action('init', 'JL_register_jl_location');
// Disable the "No term" option on the "jl_location" taxonomy
add_filter("radio_buttons_for_taxonomies_no_term_jl_location", "__return_FALSE");

// 08. Register "jl_category" taxonomy
function JL_register_jl_category() {

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
    "rest_base" => "jl-categories",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => true,
    "sort" => false,
    "show_in_graphql" => false,
  ];
  register_taxonomy("jl_category", ["jl_job"], $args);
}
add_action('init', 'JL_register_jl_category');
// Disable the "No term" option on the "jl_category" taxonomy
add_filter("radio_buttons_for_taxonomies_no_term_jl_category", "__return_FALSE");

// 09. Register "jl_type" taxonomy
function JL_register_jl_type() {

  $labels = [
    "name" => "Types",
    "singular_name" => "Type",
    "menu_name" => "Types",
    "all_items" => "All Types",
    "edit_item" => "Edit Type",
    "view_item" => "View Type",
    "update_item" => "Update Type name",
    "add_new_item" => "Add new Type",
    "new_item_name" => "New Type name",
    "parent_item" => "Parent Type",
    "parent_item_colon" => "Parent Type:",
    "search_items" => "Search Types",
    "popular_items" => "Popular Types",
    "separate_items_with_commas" => "Separate Types with commas",
    "add_or_remove_items" => "Add or remove Types",
    "choose_from_most_used" => "Choose from the most used Types",
    "not_found" => "No Types found",
    "no_terms" => "No Types",
    "items_list_navigation" => "Types list navigation",
    "items_list" => "Types list",
    "back_to_items" => "Back to Types",
    "name_field_description" => "The name is how it appears on your site.",
    "parent_field_description" => "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.",
    "slug_field_description" => "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.",
    "desc_field_description" => "The description is not prominent by default; however, some themes may show it.",
  ];

  $args = [
    "label" => "Types",
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
    "rest_base" => "jl-types",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => true,
    "sort" => false,
    "show_in_graphql" => false,
  ];
  register_taxonomy("jl_type", ["jl_job"], $args);
}
add_action('init', 'JL_register_jl_type');
// Disable the "No term" option on the "jl_type" taxonomy
add_filter("radio_buttons_for_taxonomies_no_term_jl_type", "__return_FALSE");

// 10. Register "jl_experience_level" taxonomy
function JL_register_jl_experience_level() {

  $labels = [
    "name" => "Experience Levels",
    "singular_name" => "Experience Level",
    "menu_name" => "Experience Levels",
    "all_items" => "All Experience Levels",
    "edit_item" => "Edit Experience Level",
    "view_item" => "View Experience Level",
    "update_item" => "Update Experience Level name",
    "add_new_item" => "Add new Experience Level",
    "new_item_name" => "New Experience Level name",
    "parent_item" => "Parent Experience Level",
    "parent_item_colon" => "Parent Experience Level:",
    "search_items" => "Search Experience Levels",
    "popular_items" => "Popular Experience Levels",
    "separate_items_with_commas" => "Separate Experience Levels with commas",
    "add_or_remove_items" => "Add or remove Experience Levels",
    "choose_from_most_used" => "Choose from the most used Experience Levels",
    "not_found" => "No Experience Levels found",
    "no_terms" => "No Experience Levels",
    "items_list_navigation" => "Experience Levels list navigation",
    "items_list" => "Experience Levels list",
    "back_to_items" => "Back to Experience Levels",
    "name_field_description" => "The name is how it appears on your site.",
    "parent_field_description" => "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.",
    "slug_field_description" => "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.",
    "desc_field_description" => "The description is not prominent by default; however, some themes may show it.",
  ];

  $args = [
    "label" => "Experience Levels",
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
    "rest_base" => "jl-experience-levels",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => true,
    "sort" => false,
    "show_in_graphql" => false,
  ];
  register_taxonomy("jl_experience_level", ["jl_job"], $args);
}
add_action('init', 'JL_register_jl_experience_level');
// Disable the "No term" option on the "jl_experience_level" taxonomy
add_filter("radio_buttons_for_taxonomies_no_term_jl_experience_level", "__return_FALSE");

// 11. Disable the Gutenberg editor for the custom post type "jl_job"
function JL_disable_gutenberg_editor($can_edit, $post_type) {
  if ( 'jl_job' == $post_type ) {
      $can_edit = false;
  }
  return $can_edit;
}
add_filter('use_block_editor_for_post_type', 'JL_disable_gutenberg_editor', 10, 2);

// 12. Utility function that process the taxonomy term for the REST API response
function JL_process_taxonomy_term($term_id) {
  $result = new stdClass();
  // Use slug as id
  $result->id = get_term($term_id)->slug;
  // Use html_entity_decode() to avoid html entities like &amp;
  $result->name = html_entity_decode(get_term($term_id)->name);
  return $result;
}

// 13. Filter the "jl_job" post data for the REST API response
function JL_filter_rest_jl_job($response) {
  $location = JL_process_taxonomy_term($response->data['jl-locations'][0]);
  $category = JL_process_taxonomy_term($response->data['jl-categories'][0]);
  $type = JL_process_taxonomy_term($response->data['jl-types'][0]);
  $experience_level = JL_process_taxonomy_term($response->data['jl-experience-levels'][0]);

  return [
    'id' => $response->data['id'],
    'modified' => $response->data['modified'],
    'modified_gmt' => $response->data['modified_gmt'],
    // Use html_entity_decode() to avoid html entities like &amp;
    'title' => html_entity_decode($response->data['title']['rendered']),
    'content' => html_entity_decode($response->data['content']['rendered']),
    'location' => $location,
    'category' => $category,
    'type' => $type,
    'experience_level' => $experience_level,
  ];
}
add_filter('rest_prepare_jl_job', 'JL_filter_rest_jl_job');

// 14. Filter the "jl_location" taxonomy data for the REST API response
function JL_filter_rest_jl_location($response) {
  return [
    // Use slug as id
    'id' => $response->data['slug'],
    'count' => $response->data['count'],
    // Use html_entity_decode() to avoid html entities like &amp;
    'name' => html_entity_decode($response->data['name']),
  ];
}
add_filter('rest_prepare_jl_location', 'JL_filter_rest_jl_location');

// 15. Filter the "jl_category" taxonomy data for the REST API response
function JL_filter_rest_jl_category($response) {
  return [
    // Use slug as id
    'id' => $response->data['slug'],
    'count' => $response->data['count'],
    // Use html_entity_decode() to avoid html entities like &amp;
    'name' => html_entity_decode($response->data['name']),
  ];
}
add_filter('rest_prepare_jl_category', 'JL_filter_rest_jl_category');