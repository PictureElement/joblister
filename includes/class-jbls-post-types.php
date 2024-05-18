<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JBLS_Post_Types
{
  // Constructor
  public function __construct()
  {
    add_action('init', array($this, 'jbls_init'));
    add_filter('use_block_editor_for_post_type', array($this, 'jbls_disable_gutenberg_editor'), 10, 2);
  }

  // Initialize custom post types
  public function jbls_init() {
    $this->jbls_register_cpt_jbls_job();
    $this->jbls_register_cpt_jbls_application();
  }

  // Register "jbls_job" post type
  public function jbls_register_cpt_jbls_job()
  {
    $labels = [
      "name" => "Jobs",
      "singular_name" => "Job",
      "menu_name" => "JobLister",
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
      "show_in_rest" => false,
      "has_archive" => false,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "delete_with_user" => false,
      "exclude_from_search" => true,
      "capability_type" => "post",
      "map_meta_cap" => true,
      "hierarchical" => false,
      "can_export" => true,
      "rewrite" => true,
      "query_var" => true,
      "supports" => ["title", "editor"],
      "show_in_graphql" => false,
    ];

    register_post_type("jbls_job", $args);
  }

  // Disable the Gutenberg editor for the custom post type "jbls_job"
  public function jbls_disable_gutenberg_editor($can_edit, $post_type)
  {
    if ('jbls_job' == $post_type) {
      $can_edit = false;
    }
    return $can_edit;
  }

  // Register "jbls_application" post type
  public function jbls_register_cpt_jbls_application()
  {
    $labels = [
      "name" => "Applications",
      "singular_name" => "Application",
      "menu_name" => "Applications",
      "all_items" => "All Applications",
      "add_new" => "Add New",
      "add_new_item" => "Add New Application",
      "edit_item" => "Edit Application",
      "new_item" => "New Application",
      "view_item" => "View Application",
      "view_items" => "View Applications",
      "search_items" => "Search Applications",
      "not_found" => "No Applications found",
      "not_found_in_trash" => "No Applications found in trash",
      "parent" => "Parent Application:",
      "featured_image" => "Featured image for this Application",
      "set_featured_image" => "Set featured image for this Application",
      "remove_featured_image" => "Remove featured image for this Application",
      "use_featured_image" => "Use as featured image for this Application",
      "archives" => "Application archives",
      "insert_into_item" => "Insert into Application",
      "uploaded_to_this_item" => "Upload to this Application",
      "filter_items_list" => "Filter Applications list",
      "items_list_navigation" => "Applications list navigation",
      "items_list" => "Applications list",
      "attributes" => "Applications attributes",
      "name_admin_bar" => "Application",
      "item_published" => "Application published",
      "item_published_privately" => "Application published privately.",
      "item_reverted_to_draft" => "Application reverted to draft.",
      "item_scheduled" => "Application scheduled",
      "item_updated" => "Application updated.",
      "parent_item_colon" => "Parent Application:",
    ];

    $args = [
      "label" => "Applications",
      "labels" => $labels,
      "description" => "",
      "public" => false,
      "publicly_queryable" => false,
      "show_ui" => true,
      "show_in_rest" => false,
      "has_archive" => false,
      "show_in_menu" => 'edit.php?post_type=jbls_job', // Set the menu location to match the "jbls_job" post type
      "show_in_nav_menus" => true,
      "delete_with_user" => false,
      "exclude_from_search" => true,
      "capability_type" => "post",
      "map_meta_cap" => true,
      "hierarchical" => false,
      "can_export" => true,
      "rewrite" => true,
      "query_var" => true,
      "supports" => false,
      "show_in_graphql" => false,
    ];

    register_post_type("jbls_application", $args);
  }
}
