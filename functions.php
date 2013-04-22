<?php
/**
 * @package CloudWork
 * @subpackage functions.php
 * @author Chris Kelley <chris@organicbeemedia.com)
 * @copyright Copyright © 2013 Organic Bee Media
 * @link http://cloudworkthemes.com
 * @since 0.1
 *
 * Table Of Contents
 *
 * Define Environment
 * Load Options Framework
 * Load Theme Files
 * cw_theme_setup
 */

//Sets the Content Width
if ( ! isset( $content_width ) ) $content_width = 960;

/*-----------------------------------------------------------------------------------*/
/* Define Environment
/*-----------------------------------------------------------------------------------*/

/* Sets the path to the parent theme directory. */
define( 'THEME_DIR', get_template_directory() );

/* Sets the path to the parent theme directory URI. */
define( 'THEME_URI', get_template_directory_uri() );
		
/* Sets the path to the includes directory. */
define( 'CW_CORE', trailingslashit( THEME_DIR ) . 'functions' );
		
/* Sets the path to the includes directory. */
define( 'CW_INC', trailingslashit( THEME_DIR ) . 'includes' );

/* Sets the path to the Lang directory. */
define( 'CW_LANG', trailingslashit( THEME_DIR ) . 'language' );

/* Sets the path to the Media directory. */
define( 'CW_MEDIA', trailingslashit( THEME_URI ) . 'media' );
		
define( 'CW_CSS', trailingslashit( CW_MEDIA ) . 'css' );
		
define( 'CW_ADMIN_CSS', trailingslashit( CW_CSS ) . 'admin' );
		
define( 'CW_JS', trailingslashit( CW_MEDIA ) . 'scripts' );	
		
define( 'CW_ADMIN_JS', trailingslashit( CW_JS ) . 'admin' );
		
define( 'CW_IMAGES', trailingslashit( CW_MEDIA ) . 'images' );

/*-----------------------------------------------------------------------------------*/
/* Loads Framework stuff
/*-----------------------------------------------------------------------------------*/

//framework loads the rest of the files
require_once trailingslashit( CW_CORE ) . 'cw-customizer-framework.php';

/*-----------------------------------------------------------------------------------*/
/*  All Custom Code goes below this line, but you should be using a child theme!
/*-----------------------------------------------------------------------------------*/


?>