<?php
// get_field, normally provided by Advanced Custom Fields
if ( !function_exists('get_field') ) {
	function get_field( $name, $post_id = null, $format = null ) {
		if ( $post_id === null ) $post_id = get_the_ID();

		if ( is_string($post_id) && substr(strtolower($post_id), 0, 6) == 'option' ) {
			return get_option( "options_" . $name );
		}else{
			return get_post_meta( $post_id, $name, true );
		}
	}
}

// update_field, normally provided by Advanced Custom Fields
if ( !function_exists('update_field') ) {
function update_field( $name, $value, $post_id = null, $format = null ) {
	if ( $post_id === null ) $post_id = get_the_ID();

	if ( is_string($post_id) && substr(strtolower($post_id), 0, 6) == 'option' ) {
		update_option( "options_" . $name, $value );
	}else{
		update_post_meta( $post_id, $name, $value );
	}

	return true;
}
}