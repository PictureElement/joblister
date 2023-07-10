<?php

// If this file is access directly, abort!
defined('ABSPATH') or die('Unauthorized Access');

// Add a meta box to the "jl_application" post type screen
function jl_add_jl_application_fields() {
  add_meta_box(
    'jl-application-fields',
    'Application Details',
    'jl_render_jl_application_fields',
    'jl_application',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes_jl_application', 'jl_add_jl_application_fields');

// Fill the meta box with the desired content
function jl_render_jl_application_fields($post) {
  $job_id = get_post_meta($post->ID, 'job_id', true);
  $name = get_post_meta($post->ID, 'name', true);
  $email = get_post_meta($post->ID, 'email', true);
  ?>
  <div>
    <label for="job_id">Add Job ID</label>
    <input type="text" id="job_id" name="job_id" autocomplete="off" value="<?php echo esc_attr($job_id); ?>">
  </div>
  <div>
    <label for="name">Add Name</label>
    <input type="text" id="name" name="name" autocomplete="off" value="<?php echo esc_attr($name); ?>">
  </div>
  <div>
    <label for="email">Add Email</label>
    <input type="email" id="email" name="email" value="<?php echo esc_attr($email); ?>">
  </div>
  <?php
}

// Update "jl_application" meta fields once a post has been saved
function jl_save_jl_application_fields($post_id) {
  if (isset($_POST['job_id'])) {
    update_post_meta($post_id, 'job_id', sanitize_text_field($_POST['job_id']));
  }
  if (isset($_POST['name'])) {
    update_post_meta($post_id, 'name', sanitize_text_field($_POST['name']));
  }
  if (isset($_POST['email'])) {
    update_post_meta($post_id, 'email', sanitize_email($_POST['email']));
  }
}
add_action('save_post', 'jl_save_jl_application_fields');
