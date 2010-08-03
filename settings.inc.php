<?php //Takes care of the settings panel on the admin page

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

add_action('admin_menu', 'jpsocial_menu');
register_activation_hook(__FILE__, 'add_defaults_fn');

function jpsocial_menu()
{
	add_options_page('JP Social Bookmarks Settings', 'Social Bookmarks', 'administrator', __FILE__, 'jpsocial_options');
}

function jpsocial_options()
{		
	if (!current_user_can('manage_options'))
  	{
  		wp_die('You do not have sufficient permissions to access this page.');
  	}
	
	$title = __('JP Social Bookmarks Settings');
	
	?>
    
	<style type="text/css">
	 .plugin_form{float:left;margin:10px 20px 15px 0;width:300px}
	 .plugin_form dt{color:#666}
	 .plugin_form dt a.uiTooltip{font-weight:normal;font-size:11px}
	 .plugin_form dd{padding:5px 0 10px 0;border-bottom:solid #D0D0D0 1px;margin-bottom:5px}
	 .plugin_form dd label{color:#000;font-weight:normal}
	 .plugin_form .wideinputtext{width:210px}
	</style>
 
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>JP Social Bookmarks Settings</h2>
		Configure some additional options to customize the appearance of the plugin.
		<form action="options.php" method="post">
		<?php settings_fields('jpsocial_options'); ?>
		<?php do_settings_sections(__FILE__); ?>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>
		</form>
	</div>
    
	<?php
}

add_action('admin_init', 'jpsocial_init_fn' );

function jpsocial_init_fn()
{
	register_setting('jpsocial_options', 'jpsocial_options', 'plugin_options_validate' );
	add_settings_section('main_section', 'Main Settings', 'section_text_fn', __FILE__);
	add_settings_field('plugin_text_string', 'Enter your Twitter username:', 'setting_string_fn', __FILE__, 'main_section');
}

function setting_string_fn()
{
	$options = get_option('jpsocial_options');
	echo "<input id='plugin_text_string' name='jpsocial_options[twitterusername]' size='40' type='text' value='{$options['twitterusername']}' />";
}


function add_defaults_fn()
{	
	$arr = array("twitterusername" => "jonpreecebsc");
	update_option('jpsocial_options', $arr);
}

function plugin_options_validate($input)
{
	$input['twitterusername'] =  wp_filter_nohtml_kses($input['twitterusername']);	
	return $input;
}

?>