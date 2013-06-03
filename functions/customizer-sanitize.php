<?php
/**
 * @package CloudWork
 * @subpackage cw-sanitize.php
 * @version 1.0
 * @author Chris Kelley <chris@organicbeemedia.com)
 * @copyright Copyright � 2013 Organic Bee Media
 * @link http://organicbeemedia.com
 * @since 0.1
 * @todo
 */

/* Text */

add_filter( 'cw_cf_sanitize_text', 'sanitize_text_field' );

/* Textarea */
add_filter( 'cw_cf_sanitize_textarea', 'cw_cf_sanitize_textarea' );
/**
 * Sanitize Textarea
 * 
 * @since 0.1
 * @access public
 * @param mixed $input
 * @return string
 */
function cw_cf_sanitize_textarea($input) {
	
	global $allowedposttags;
	
	$output = wp_kses( $input, $allowedposttags);
	
	return $output;
}

add_filter( 'cw_cf_sanitize_dropdown-pages', 'cw_cf_sanitize_pages' );

function cw_cf_sanitize_pages($input) {
	
	$output = sanitize_text_field( $input );
	
	return $output;
}


/* Checkbox */
add_filter( 'cw_cf_sanitize_checkbox', 'cw_cf_sanitize_checkbox' );

/**
 * Sanitize Checkbox
 * 
 * @since 0.1
 * @access public
 * @param mixed $input
 * @return int|bool
 */
function cw_cf_sanitize_checkbox( $input ) {
	
	if ( $input ) {
		
		$output = '1';
	
	} else {
		
		$output = false;
	
	}
	
	return $output;
}

/* Uploader */
add_filter( 'cw_cf_sanitize_image', 'cw_cf_sanitize_upload' );
add_filter( 'cw_cf_sanitize_file', 'cw_cf_sanitize_upload' );

/**
 * Sanitize Upload
 * 
 * @since 0.1
 * @access public
 * @param mixed $input
 * @return string
 */
function cw_cf_sanitize_upload( $input ) {
	
	$output = '';
	
	$filetype = wp_check_filetype($input);
	
	if ( $filetype["ext"] ) {
	
		$output = $input;
	
	}
	
	return $output;

}

/**
 * Allowed Post Tags.
 * 
 * @since 0.1
 * @access public
 * @param mixed $input
 * @return string
 */
function cw_cf_sanitize_allowedposttags($input) {
	
	global $allowedposttags;
	
	$output = wpautop(wp_kses( $input, $allowedposttags));
	
	return $output;

}

//
add_filter( 'cw_cf_sanitize_select', 'cw_cf_sanitize_enum', 10, 2);
add_filter( 'cw_cf_sanitize_radio', 'cw_cf_sanitize_enum', 10, 2);

/**
 * Check that the key value sent is valid
 * 
 * @since 0.1
 * @access public
 * @param mixed $input
 * @param mixed $option
 * @return mixed
 */
function cw_cf_sanitize_enum( $input, $option ) {
	
	$output = '';
	
	if ( array_key_exists( $input, $option['choices'] ) ) {
	
		$output = $input;
	
	}
	
	return $output;
}

add_filter( 'cw_cf_sanitize_color', 'cw_cf_sanitize_hex' );

/**
 * Sanitize a color represented in hexidecimal notation.
 * 
 * @access public
 * @param string $hex Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @param string $default (default: '')  The value that this function should return if it cannot be recognized as a color.
 * @return string
 */
function cw_cf_sanitize_hex( $hex, $default = '' ) {
	
	if ( cw_validate_hex( $hex ) ) {
	
		return $hex;
	
	}
	
	return $default;

}
/**
 * Is a given string a color formatted in hexidecimal notation?
 * 
 * @since 0.1
 * @access public
 * @param mixed $hex
 * @return bool
 */
function cw_cf_validate_hex( $hex ) {
	
	$hex = trim( $hex );
	
	/* Strip recognized prefixes. */
	if ( 0 === strpos( $hex, '#' ) ) {
	
		$hex = substr( $hex, 1 );
	
	}
	
	elseif ( 0 === strpos( $hex, '%23' ) ) {
	
		$hex = substr( $hex, 3 );
	
	}
	
	/* Regex match. */
	if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
	
		return false;
	
	} else {
	
		return true;
	
	}
}

?>