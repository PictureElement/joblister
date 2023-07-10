<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JL_Meta_Boxes
{
  public function __construct()
  {
    add_action('add_meta_boxes_jl_application', array($this, 'add_jl_application_fields'));
    add_action('save_post', array($this, 'save_jl_application_fields'));
  }

  // Add a meta box to the "jl_application" post type screen
  public function add_jl_application_fields()
  {
    add_meta_box(
      'jl-application-fields',
      'Application Details',
      array($this, 'render_jl_application_fields'),
      'jl_application',
      'normal',
      'high'
    );
  }

  // Fill the meta box with the desired content
  private function render_jl_application_fields($post)
  {
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
  public function save_jl_application_fields($post_id)
  {
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
}

// Initialize the JL_Meta_Boxes
new JL_Meta_Boxes();
