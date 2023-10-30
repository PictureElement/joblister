<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JL_Shortcodes
{
  // Constructor
  public function __construct()
  {
    add_shortcode('joblister', array($this, 'joblister_func'));
  }

  // Register shortcode
  public function joblister_func()
  {
    // Enqueue scripts and styles
    wp_enqueue_script('jl-script');
    wp_enqueue_style('jl-style');

    return '<div class="jl-root" id="jl-root"></div>';
  }
}
