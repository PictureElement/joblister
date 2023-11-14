<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class JL_Custom_Taxonomies
{

  public function __construct()
  {
    add_action('init', [$this, 'register_jl_location']);
    add_action('init', [$this, 'register_jl_category']);
    add_action('init', [$this, 'register_jl_type']);
    add_action('init', [$this, 'register_jl_experience_level']);
    // Disable the "No term" option on the "jl_location" taxonomy
    add_filter("radio_buttons_for_taxonomies_no_term_jl_location", [$this, '__return_FALSE']);
    add_filter("radio_buttons_for_taxonomies_no_term_jl_category", [$this, '__return_FALSE']);
    add_filter("radio_buttons_for_taxonomies_no_term_jl_type", [$this, '__return_FALSE']);
    add_filter("radio_buttons_for_taxonomies_no_term_jl_experience_level", [$this, '__return_FALSE']);
  }

  // Register "jl_location" taxonomy
  public function register_jl_location()
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
      "rewrite" => true,
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

  // Register "jl_category" taxonomy
  public function register_jl_category()
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
      "rewrite" => true,
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

  // Register "jl_type" taxonomy
  public function register_jl_type()
  {
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
      "rewrite" => true,
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

  // Register "jl_experience_level" taxonomy
  public function register_jl_experience_level()
  {
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
      "rewrite" => true,
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

  public static function __return_FALSE()
  {
    return false;
  }
}
