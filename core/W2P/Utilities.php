<?php

class W2P_Utilities
{
	public static $registerUploadType = false;
	
	public static function setRegisterUploadType()
	{
		register_post_type( 'w2pupload', array(
				'labels' => array(
						'name' => __( 'Theme Options Media' ),
				),
				'public' => true,
				'show_ui' => false,
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => false,
				'supports' => array( 'title', 'editor' ),
				'query_var' => false,
				'can_export' => true,
				'show_in_nav_menus' => false,
				'public' => false
		) );
	}
	
	public static function w2pUploadId($_name) {
		global $wpdb;
		self::setRegisterUploadType();
		$_id = 0;
		// Check if the token is valid against a whitelist.
		// $_whitelist = array( 'of_logo', 'of_custom_favicon',
		// 'of_ad_top_image' );
		// Sanitise the token.
		if (! $_name)
			throw new W2P_Exception ( __ ( 'Must be informed a valid name!', 'W2P' ) );
		
		$_name = strtolower ( str_replace ( ' ', '_', $_name ) );
		
		// Tell the function what to look for in a post.
		
		$_args = array ('post_type' => 'w2pupload', 'post_name' => 'of-' . $_name, 'post_status' => 'draft', 'comment_status' => 'closed', 'ping_status' => 'closed' );
		
		// Look in the database for a "silent" post that meets our criteria.
		$query = 'SELECT ID FROM ' . $wpdb->posts . ' WHERE post_parent = 0';
		foreach ( $_args as $k => $v ) {
			$query .= ' AND ' . $k . ' = "' . $v . '"';
		} // End FOREACH Loop
		
		$query .= ' LIMIT 1';
		$_posts = $wpdb->get_row ( $query );
		
		// If we've got a post, loop through and get it's ID.
		if (count ( $_posts )) {
			$_id = $_posts->ID;
		} else {
			
			// If no post is present, insert one.
			// Prepare some additional data to go with the post insertion.
			$_words = explode ( '_', $_name );
			$_title = join ( ' ', $_words );
			$_title = ucwords ( $_title );
			$_post_data = array ('post_title' => $_title );
			$_post_data = array_merge ( $_post_data, $_args );
			$_id = wp_insert_post ( $_post_data );
		}
		return $_id;
	}
}