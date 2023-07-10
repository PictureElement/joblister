<?php

// If this file is access directly, abort!
defined('ABSPATH') or die('Unauthorized Access');

// Filter the columns displayed in the Posts list table for the "jl_application" post type
function jl_add_jl_application_columns($columns) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'id' => 'ID',
    'name' => 'Name',
    'email' => 'Email',
    'job_title' => 'Job Title',
    'date' => 'Date'
  );
  return $columns;
}
add_filter('manage_jl_application_posts_columns', 'jl_add_jl_application_columns');

// Populate custom column data in the Posts list table for the "jl_application" post type
function jl_populate_jl_application_columns($column, $post_id) {
  switch ($column) {
    case 'id':
      echo $post_id;
      break;
    case 'name':
      $name = get_post_meta($post_id, 'name', true);
      echo $name;
      break;
    case 'email':
      $email = get_post_meta($post_id, 'email', true);
      echo $email;
      break;
    case 'job_title':
      $job_id = get_post_meta($post_id, 'job_id', true);
      if ($job_id) {
        $job_title = get_the_title($job_id);
        echo $job_title;
      } else {
        echo '—';
      }
      break;
  }
}
add_action('manage_jl_application_posts_custom_column', 'jl_populate_jl_application_columns', 10, 2);

// Filter the columns displayed in the Posts list table for the "jl_job" post type
function jl_add_jl_job_columns($columns) {
  $columns['post_id'] = 'ID';
  return $columns;
}
add_filter('manage_jl_job_posts_columns', 'jl_add_jl_job_columns');

// Populate custom column data in the Posts list table for the "jl_job" post type
function jl_populate_jl_job_columns($column, $post_id) {
  if ($column === 'post_id') {
    echo $post_id;
  }
}
add_action('manage_jl_job_posts_custom_column', 'jl_populate_jl_job_columns', 10, 2);
