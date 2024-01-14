<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JBLS_Admin_Columns
{
  public function __construct()
  {
    add_filter('manage_jbls_application_posts_columns', array($this, 'jbls_add_jbls_application_columns'));
    add_action('manage_jbls_application_posts_custom_column', array($this, 'jbls_populate_jbls_application_columns'), 10, 2);
    add_filter('manage_jbls_job_posts_columns', array($this, 'jbls_add_jbls_job_columns'));
    add_action('manage_jbls_job_posts_custom_column', array($this, 'jbls_populate_jbls_job_columns'), 10, 2);
  }

  // Filter the columns displayed in the Posts list table for the "jbls_application" post type
  public function jbls_add_jbls_application_columns($columns)
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

  // Populate custom column data in the Posts list table for the "jbls_application" post type
  public function jbls_populate_jbls_application_columns($column, $post_id)
  {
    switch ($column) {
      case 'id':
        echo esc_html($post_id);
        break;
      case 'name':
        $name = get_post_meta($post_id, 'name', true);
        echo $name ? esc_html($name) : '—';
        break;
      case 'email':
        $email = get_post_meta($post_id, 'email', true);
        echo $email ? esc_html($email) : '—';
        break;
      case 'job_title':
        $job_id = get_post_meta($post_id, 'job_id', true);
        if ($job_id) {
          $job_post = get_post($job_id);
          if ($job_post) {
            $title = get_the_title($job_id);
            if ($title) {
              echo esc_html($title);
            } else {
              echo '(no title)';
            }
          } else {
            echo '—';
          }
        } else {
          echo '—';
        }
        break;
    }
  }

  // Filter the columns displayed in the Posts list table for the "jbls_job" post type
  public function jbls_add_jbls_job_columns($columns)
  {
    $columns['post_id'] = 'ID';
    return $columns;
  }

  // Populate custom column data in the Posts list table for the "jbls_job" post type
  public function jbls_populate_jbls_job_columns($column, $post_id)
  {
    if ($column === 'post_id') {
      echo esc_html($post_id);
    }
  }
}
