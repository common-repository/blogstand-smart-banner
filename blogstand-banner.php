<?php
/**
 * @package BlogstandBanner
 * @version 1.0
 */
/*
Plugin Name: Blogstand Banner
Plugin URI: http://blogstand.co/
Description: Tells your iPhone, iPad and iPod Touch readers that they can view your blog using Blogstand. The best way to read, comment, and follow your favourite WordPress blogs on tablets and touch devices.
Author: Appifier Technology, Inc.
Version: 1.0
Author URI: http://theappifier.com/
License: GPL
*/

/*  Copyright 2012 Appifier Technology, Inc.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// This just echoes the chosen line, we'll position it later
function bs_output_smart_banner($post_ID) {
  $blog_id = get_option('bs_blog_id');
  if(isset($blog_id) && strlen($blog_id) > 5) {
    echo "<meta name=\"apple-itunes-app\" content=\"app-id=557736881,app-argument=blogstand://$blog_id\">";
  } else {
    echo "<meta name=\"apple-itunes-app\" content=\"app-id=557736881\">";
  }
}

add_action( 'wp_head', 'bs_output_smart_banner' );

// Admin menu gubbins
function bs_smart_banner_admin() {
  add_options_page( 'Blogstand Banner Options',
                    'Blogstand Banner',
                    'manage_options',
                    'bs-banner',
                    'bs_banner_options' );
}

function bs_banner_options() {
    if (current_user_can('manage_options')) {
          $hidden_field = 'blogstand_hidden';
          $blog_id_field = 'bs_blog_id';

          $blog_id = get_option( $blog_id_field );

          if( isset($_POST[ $hidden_field ]) && $_POST[ $hidden_field ] == 'SET' ) {
              $blog_id = $_POST[ $blog_id_field ];
              update_option( $blog_id_field, $blog_id );
      ?>
      <div class="updated"><p><strong><?php _e('The Blog ID was successfully saved!', 'bs-banner' ); ?></strong></p></div>
      <?php

          }
      ?>
      <div class="wrap">
      
      <?php
        echo "<h2>" . __( 'Blogstand Banner Settings', 'bs-banner' ) . "</h2>";
      ?>

      <form name="form1" method="post" action="">
      <input type="hidden" name="<?php echo $hidden_field; ?>" value="SET">

      <p>Enter your Blog ID in the field below.</p>
      <p>You can find your Blog ID in the Blogstand Engine at <a href="http://app.blogstand.co">http://app.blogstand.co</a>.</p>

      <table>

        <tr>
          <td>Blog Id:</td>
          <td><input type="text" name="<?php echo $blog_id_field; ?>" value="<?php echo $blog_id; ?>" /></td>
        </tr>

      </table>


      <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save') ?>" />
      </p>

      </form>
      </div>

      <?php      
    } else {
      wp_die( __('You do not have permission to modify these settings.') );
    }
}

add_action( 'admin_menu', 'bs_smart_banner_admin' );

?>
