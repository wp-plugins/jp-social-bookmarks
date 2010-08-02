<?php
/*
Plugin Name: JP-Social-Bookmarks
Plugin URI: http://www.jpreece.com/tutorials/wordpress/jp-social-bookmarks/
Description: Adds social bookmarks to your website
Version: 0.2
Author: Jonathan Preece
Author URI: http://www.jpreece.com
License: GPL2
*/

/*  Copyright 2010 Jonathan Preece  (email : info@jpreece.com )

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

/* Gives us the ability to customize the widget via a seperate settings form */
require_once 'settings.inc.php';

/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'jpsb_load_widgets' );

/* Function that registers our widget. */
function jpsb_load_widgets()
{
	register_widget( 'jpsb_Widget' );
}

class JPSB_Widget extends WP_Widget
{
	function JPSB_Widget()
	{
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'jpsb', 'description' => 'Adds social bookmarks to your website');

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'jpsb-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'jpsb-widget', 'JP-Social-Bookmarks', $widget_ops, $control_ops );
	}
		
	function widget( $args, $instance )
	{
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		?>	
        <div id="jp-social-bookmarks-styles" style="text-align:center; padding-top:10px">
                
		<?php query_posts('showposts=1&cat=1'); ?>  
		<?php while (have_posts()) : the_post(); ?>   
		  <?php
                  
          $social_permalink = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
          $social_title = the_title('','', false);
          $social_plugin_url = WP_PLUGIN_URL . '/jp-social-bookmarks';
          $social_twitter_username = get_option('jpsocial_options');
          
          if ($social_twitter_username['twitterusername']=="")
              $social_twitter_username = "jonpreecebsc";
          else
              $social_twitter_username = $social_twitter_username['twitterusername']; 
              
          ?>
		<?php endwhile; ?>
        
		<a href="http://del.icio.us/post?url=<?php echo $social_permalink; ?>&amp;amp;title=<?php echo urlencode($social_title); ?>" target="_blank" title="Bookmark with del.icio.us" alt="del.icio.us"><img src="<?php echo $social_plugin_url; ?>/icons/delicious_32.png" width="32" height="32" alt="del.icio.us" /></a>
        
		<a href="http://designfloat.com/submit.php?url=<?php echo $social_permalink; ?>&amp;amp;title=<?php echo urlencode($social_title); ?>" target="_blank" title="Bookmark with Design Float" alt="designfloat"><img src="<?php echo $social_plugin_url; ?>/icons/designfloat_32.png" width="32" height="32" alt="Design Float" /></a>
        
		<a href="http://digg.com/submit?phase=2&amp;amp;url=<?php echo $social_permalink; ?>&amp;amp;title=<?php echo urlencode($social_title); ?>" target="_blank" title="Digg this!" alt="digg"><img src="<?php echo $social_plugin_url; ?>/icons/digg_32.png" width="32" height="32" alt="Digg This!" /></a>
        
		<a href="http://facebook.com/share.php?u=<?php echo $social_permalink; ?>&amp;amp;t=<?php echo urlencode($social_title); ?>" target="_blank" title="Bookmark with Facebook" alt="Facebook"><img src="<?php echo $social_plugin_url; ?>/icons/facebook_32.png" width="32" height="32" alt="Share on Facebook" /></a>
        
		<a href="http://mixx.com/submit?page_url=<?php echo $social_permalink; ?>&amp;amp;title=<?php echo urlencode($social_title); ?>" target="_blank" title="Bookmark with mixx" alt="mixx"><img src="<?php echo $social_plugin_url; ?>/icons/mixx_32.png" width="32" height="32" alt="mixx" /></a>
        
		<a href="http://reddit.com/submit?url=<?php echo $social_permalink; ?>&amp;amp;title=<?php echo urlencode($social_title); ?>" target="_blank" title="Bookmark with Reddit" alt="reddit"><img src="<?php echo $social_plugin_url; ?>/icons/reddit_32.png" width="32" height="32" alt="reddit" /></a>
        
		<a href="http://stumbleupon.com/submit?url=<?php echo $social_permalink; ?>&amp;amp;title=<?php echo urlencode($social_title); ?>" target="_blank" title="Bookmark with Stumbleupon" alt="stumbleupon"><img src="<?php echo $social_plugin_url; ?>/icons/stumbleupon_32.png" width="32" height="32" alt="stumbleupon" /></a>
        
		<a href="http://technorati.com/faves?add=<?php echo $social_permalink; ?>&amp;amp;title=<?php echo urlencode($social_title); ?>" target="_blank" title="Bookmark with Technorati" alt="technorati"><img src="<?php echo $social_plugin_url; ?>/icons/technorati_32.png" width="32" height="32" alt="technorati" /></a>
        
		<a href="http://twitter.com/<?php echo $social_twitter_username; ?>" target="_blank"><img src="<?php echo $social_plugin_url; ?>/icons/twitter_32.png" width="32" height="32" alt="Follow me on Twitter" title="Follow me on Twitter" /></a>
        
		<a href="<?php echo get_bloginfo("url"); ?>/feed/" target="_blank"><img src="<?php echo $social_plugin_url; ?>/icons/rss_32.png" width="32" height="32" alt="Subscribe to RSS feed" title="Subscribe to RSS feed" /></a></div>
<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}
	
	function form( $instance )
	{
		/* Set up some default widget settings. */
		$defaults = array( 'title' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

        <?php
	}        
}

?>