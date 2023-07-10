<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JL_Admin_Columns
{
  public function __construct()
  {
    add_filter('manage_jl_application_posts_columns', array($this, 'add_jl_application_columns'));
    add_action('manage_jl_application_posts_custom_column', array($this, 'populate_jl_application_columns'), 10, 2);
    add_filter('manage_jl_job_posts_columns', array($this, 'add_jl_job_columns'));
    add_action('manage_jl_job_posts_custom_column', array($this, 'populate_jl_job_columns'), 10, 2);
  }

  // Filter the columns displayed in the Posts list table for the "jl_application" post type
  public function add_jl_application_columns($columns)
  {
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

  // Populate custom column data in the Posts list table for the "jl_application" post type
  public function populate_jl_application_columns($column, $post_id)
  {
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

  // Filter the columns displayed in the Posts list table for the "jl_job" post type
  public function add_jl_job_columns($columns)
  {
    $columns['post_id'] = 'ID';
    return $columns;
  }

  // Populate custom column data in the Posts list table for the "jl_job" post type
  public function populate_jl_job_columns($column, $post_id)
  {
    if ($column === 'post_id') {
      echo $post_id;
    }
  }
}

// Initialize the JL_Admin_Columns
new JL_Admin_Columns();
