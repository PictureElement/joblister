<?php

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

if (function_exists('get_posts') && function_exists('wp_delete_post')) {
  // Delete posts of the custom post types created by your plugin
  $post_types = array('jbls_job', 'jbls_application');
  foreach ($post_types as $post_type) {
    $posts = get_posts(array('post_type' => $post_type, 'numberposts' => -1));
    foreach ($posts as $post) {
      wp_delete_post($post->ID, true);
    }
  }
}

if (function_exists('wp_delete_term')) {
  // Delete terms of the custom taxonomies created by your plugin
  $taxonomies = array('jbls_location', 'jbls_category', 'jbls_type', 'jbls_experience_level');
  foreach ($taxonomies as $taxonomy) {
    $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => false));
    foreach ($terms as $term) {
      wp_delete_term($term->term_id, $taxonomy);
    }
  }
}

// Delete the plugin options
delete_option('jbls_options');
