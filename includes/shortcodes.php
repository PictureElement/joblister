<?php

// If this file is access directly, abort!
defined('ABSPATH') or die('Unauthorized Access');

// Register shortcode
function jl_shortcode() {
  // Enqueue scripts and styles
  wp_enqueue_script('jl-script');
  wp_enqueue_style('jl-style');
  
  return '<div class="jl-root" id="jl-root"></div>';
}
add_shortcode('joblister', 'jl_shortcode');
