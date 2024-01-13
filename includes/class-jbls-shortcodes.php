<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JBLS_Shortcodes
{
  // Constructor
  public function __construct()
  {
    add_shortcode('jbls_jobs', array($this, 'jbls_add_jbls_jobs_shortcode'));
  }

  // Register shortcode
  public function jbls_add_jbls_jobs_shortcode()
  {
    // Enqueue scripts and styles
    wp_enqueue_script('jbls-script');
    wp_enqueue_style('jbls-style');

    return '<div class="jbls-root" id="jbls-root"></div>';
  }
}
