<?php
/**
 * @package CloudWork
 * @subpackage functions.php
 * @author Chris Kelley <chris@organicbeemedia.com)
 * @copyright Copyright © 2013 Cloudwork Themes
 * @link http://themeforest.net/user/chrisakelley/portfolio
 * @since 0.1
 *
 * Table Of Contents
 *
 * Define Environment
 * Load Options Framework
 * Load Theme Files
 */

//Sets the Content Width
if ( ! isset( $content_width ) ) $content_width = 960;

/*-----------------------------------------------------------------------------------*/
/* Define Environment
/*-----------------------------------------------------------------------------------*/

/* Sets the path to the parent theme directory. */
define( 'THEME_DIR', get_template_directory() );
		
/* Sets the path to the includes directory. */
define( 'CW_CORE', trailingslashit( THEME_DIR ) . 'functions' );
		
/* Sets the path to the includes directory. */
define( 'CW_INC', trailingslashit( THEME_DIR ) . 'includes' );

/* Sets the path to the Lang directory. */
define( 'CW_LANG', trailingslashit( THEME_DIR ) . 'language' );


add_filter('cw_cf_core_dir', 'cw_cf_core_path' );


/**
 * Filtering the path for the Customizer Framework.
 * 
 * @access public
 * @return void
 */
function cw_cf_core_path(){
	
	return CW_CORE;
	
}

/*-----------------------------------------------------------------------------------*/
/* Loads Framework stuff
/*-----------------------------------------------------------------------------------*/

require_once trailingslashit( CW_CORE ) . 'class-customizer-framework.php';

/*-----------------------------------------------------------------------------------*/
/* Loads Framework stuff
/*-----------------------------------------------------------------------------------*/
require_once trailingslashit( CW_INC ) . 'theme-options.php';

/*-----------------------------------------------------------------------------------*/
/*  All Custom Code goes below this line, but you should be using a child theme!
/*-----------------------------------------------------------------------------------*/

?>