<?php
/*
Plugin Name: Single Post Template
Plugin URI: http://www.nathanrice.net/plugins
Description: This plugin allows theme authors to include single post templates, much like a theme author can use page template files.
Version: 1.3
Author: Nathan Rice
Author URI: http://www.nathanrice.net/

This plugin inherits the GPL license from it's parent system, WordPress.
*/

//	This function scans the template files of the active theme, 
//	and returns an array of [Template Name => {file}.php]
if(!function_exists('get_post_templates')) {
function get_post_templates() {
	$themes = get_themes();
	$theme = get_current_theme();
	$templates = $themes[$theme]['Template Files'];
	$post_templates = array();

	$base = array(trailingslashit(get_template_directory()), trailingslashit(get_stylesheet_directory()));

	foreach ((array)$templates as $template) {
		$template = WP_CONTENT_DIR . str_replace(WP_CONTENT_DIR, '', $template); 
		$basename = str_replace($base, '', $template);

		// don't allow template files in subdirectories
		if (false !== strpos($basename, '/'))
			continue;

		$template_data = implode('', file( $template ));

		$name = '';
		if (preg_match( '|Single Post Template:(.*)$|mi', $template_data, $name))
			$name = _cleanup_header_comment($name[1]);

		if (!empty($name)) {
			if(basename($template) != basename(__FILE__))
				$post_templates[trim($name)] = $basename;
		}
	}

	return $post_templates;

}}

//	build the dropdown items
if(!function_exists('post_templates_dropdown')) {
function post_templates_dropdown() {
	global $post;
	$post_templates = get_post_templates();
	
	foreach ($post_templates as $template_name => $template_file) { //loop through templates, make them options
		if ($template_file == get_post_meta($post->ID, '_wp_post_template', true)) { $selected = ' selected="selected"'; } else { $selected = ''; }
		$opt = '<option value="' . $template_file . '"' . $selected . '>' . $template_name . '</option>';
		echo $opt;
	}
}}

//	Filter the single template value, and replace it with
//	the template chosen by the user, if they chose one.
add_filter('single_template', 'get_post_template');
if(!function_exists('get_post_template')) {
function get_post_template($template) {
	global $post;
	$custom_field = get_post_meta($post->ID, '_wp_post_template', true);
	if(!empty($custom_field) && file_exists(TEMPLATEPATH . "/{$custom_field}")) { 
		$template = TEMPLATEPATH . "/{$custom_field}"; }
	return $template;
}}

//	Everything below this is for adding the extra box
//	to the post edit screen so the user can choose a template

//	Adds a custom section to the Post edit screen
add_action('admin_menu', 'pt_add_custom_box');
function pt_add_custom_box() {
	if(get_post_templates() && function_exists( 'add_meta_box' )) {
		add_meta_box( 'pt_post_templates', __( 'Single Post Template', 'pt' ), 
			'pt_inner_custom_box', 'post', 'normal', 'high' ); //add the boxes under the post
	}
}
   
//	Prints the inner fields for the custom post/page section
function pt_inner_custom_box() {
	global $post;
	// Use nonce for verification
	echo '<input type="hidden" name="pt_noncename" id="pt_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	// The actual fields for data entry
	echo '<label class="hidden" for="post_template">' . __("Post Template", 'pt' ) . '</label><br />';
	echo '<select name="_wp_post_template" id="post_template" class="dropdown">';
	echo '<option value="">Default</option>';
	post_templates_dropdown(); //get the options
	echo '</select><br /><br />';
	echo '<p>' . __("Some themes have custom templates you can use for single posts that might have additional features or custom layouts. If so, you’ll see them above.", 'pt' ) . '</p><br />';
}

//	When the post is saved, saves our custom data
add_action('save_post', 'pt_save_postdata', 1, 2); // save the custom fields
function pt_save_postdata($post_id, $post) {
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['pt_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post->ID ))
		return $post->ID;
	} else {
		if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
	}

	// OK, we're authenticated: we need to find and save the data
	
	// We'll put the data into an array to make it easier to loop though and save
	$mydata['_wp_post_template'] = $_POST['_wp_post_template'];
	// Add values of $mydata as custom fields
	foreach ($mydata as $key => $value) { //Let's cycle through the $mydata array!
		if( $post->post_type == 'revision' ) return; //don't store custom data twice
		$value = implode(',', (array)$value); //if $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { //if the custom field already has a value...
			update_post_meta($post->ID, $key, $value); //...then just update the data
		} else { //if the custom field doesn't have a value...
			add_post_meta($post->ID, $key, $value);//...then add the data
		}
		if(!$value) delete_post_meta($post->ID, $key); //and delete if blank
	}
}
?>