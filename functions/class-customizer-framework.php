<?php
/**
 * @package CloudWork
 * @subpackage cw-options.php
 * @version 0.2
 * @author Chris Kelley <chris@organicbeemedia.com)
 * @copyright Copyright � 2013 CloudWork Themes
 * @link http://themeforest.net/user/chrisakelley/portfolio
 * @credit Devin Price http://www.wptheming.com
 *
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !defined( 'CW_CF_VERSION' ) ) {
	
	define( 'CW_CF_VERSION' ,  0.2 ); 
	
}

if( !defined( 'CW_CF_CORE' ) ) {
	
	$core_dir = apply_filters('cw_cf_core_dir', trailingslashit( get_template_directory() ) );
	
	define( 'CW_CF_CORE' , $core_dir ); 
	
}

if( !defined( 'CW_CF_LANG' ) ) {
	
	$lang = apply_filters('cw_cf_lang', 'cloudwork');
	
	define( 'CW_CF_LANG' , $lang ); 
	
}

if ( !class_exists( 'cw_Customizer' ) ) :

final class cw_Customizer{
	
	public $options;

	/**
	 * __construct function.
	 * 
	 * @since 0.1
	 * @access public
	 * @return void
	 */
	function __construct(){
		
		$this->set_options();	
		
		$this->includes();
		
		add_action( 'after_switch_theme', array( &$this , 'theme_install'));

		add_action( 'admin_init', array( &$this, 'init') );
		
		if ( cw_version_compare( 3.6 ) ) {
		
			add_action('admin_menu', array( &$this , 'add_page' ));	
		
		}
		
		add_action( 'customize_register', array( &$this, 'customizer') );
	
	}
	
	/**
	 * includes function.
	 * 
	 * @since 0.1
	 * @access public
	 * @return void
	 */
	function includes(){
		
		require_once trailingslashit( CW_CF_CORE ) . 'customizer-controls.php';

		require_once trailingslashit( CW_CF_CORE ) . 'customizer-sanitize.php';


	}
	
	/**
	 * theme_install function.
	 * 
	 * @since 0.1
	 * @access public
	 * @return void
	 */
	function theme_install() {

		$theme_name = wp_get_theme()->display('Name');

		$cw_settings['id'] = preg_replace("/\W/", "_", strtolower( $theme_name ) );
	
		/*Set theme version for Options Framework*/
		if ( get_option( 'cw_options') != strtolower( $theme_name ) ) {
	
			update_option( 'cw_options', $cw_settings );
		
		}
	
	}
	
	/**
	 * set_options function.
	 * 
	 * @access public
	 * @return void
	 */
	function set_options(){
		
		$this->options = apply_filters ( 'cw_cf_options' , $this->options );
	
		
	}
	/**
	 * init function.
	 * 
	 * @since 0.1
	 * @access public
	 * @return void
	 */
	function init(){
	
		$cw_settings = get_option('cw_options' );
	
		// Gets the unique id, returning a default if it isn't defined
		if ( isset($cw_settings['id']) ) {
	
			$option_name = $cw_settings['id'];
	
		} else {
	
			$option_name = 'cw_options';
	
		}
	
		// If the option has no saved data, load the defaults
		if ( ! get_option($option_name) ) {
	
			$this->set_defaults();
	
		}
	
		// Registers the settings fields and callback
		register_setting( 'cw_options', $option_name, array( &$this , 'validate' ) );
	
	
	}
	
	/**
	 * Adds a menu page for pre 3.6.
	 * 
	 * @since 0.1
	 * @access public
	 * @return void
	 */
	function add_page(){
	
		add_theme_page( __('Customize', CW_CF_LANG ),  __('Customize', CW_CF_LANG ), 'edit_theme_options', 'customize.php' );	
	
	}

	/**
	 * set_defaults function.
	 * 
	 * @since 0.1
	 * @access public
	 * @return void
	 */
	function set_defaults() {
	
		$cw_settings = get_option('cw_options');

		// Gets the unique option id
		$option_name = $cw_settings['id'];
	
		if ( isset($cw_settings['knownoptions']) ) {
		
			$knownoptions =  $cw_settings['knownoptions'];
		
			if ( !in_array($option_name, $knownoptions) ) {
		
				array_push( $knownoptions, $option_name );
		
				$cw_settings['knownoptions'] = $knownoptions;
		
				update_option('cw_options', $cw_settings);
			}
		
		} else {
		
			$newoptionname = array($option_name);
		
			$cw_settings['knownoptions'] = $newoptionname;
		
			update_option('cw_options', $cw_settings);
		
		}
	
		// Gets the default options data from the array in options.php
		$options = $this->options;
	
		// If the options haven't been added to the database yet, they are added now
		$values = $this->get_default_values();
	
		if ( isset($values) ) {
		
			add_option( $option_name, $values ); // Add option with default settings
	
		}

	}
	
	/**
	 * get_default_values function.
	 * 
	 * @since 0.1
	 * @access public
	 * @return void
	 */
	function get_default_values() {
	
		$output = array();
	
		$config = $this->options;
	
		foreach ( (array) $config as $option ) {
		
			if ( ! isset( $option['id'] ) ) {
		
				continue;
		
			}
		
			if ( ! isset( $option['std'] ) ) {
		
				continue;
		
				}
		
			if ( ! isset( $option['type'] ) ) {
		
				continue;
		
			}
		
			if ( has_filter( 'cw_cf_sanitize_' . $option['type'] ) ) {
		
				$output[$option['id']] = apply_filters( 'cw_cf_sanitize_' . $option['type'], $option['std'], $option );
		
			}
	
		}
	
		return $output;
	
	}
	
	/**
	 * validate function.
	 * 
	 * @since 0.1
	 * @access public
	 * @param mixed $input
	 * @return void
	 */
	function validate( $input ) {

		$clean = array();
	
		$options = $this->options;
	
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
	
				continue;
	
			}

			if ( ! isset( $option['type'] ) ) {
	
				continue;
	
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
			
				$input[$id] = false;
		
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
		
				foreach ( $option['options'] as $key => $value ) {
		
					$input[$id][$key] = false;
		
				}
		
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'cw_cf_sanitize_' . $option['type'] ) ) {
		
				$clean[$id] = apply_filters( 'cw_cf_sanitize_' . $option['type'], $input[$id], $option );
		
			}
	
		}
	
		// Hook to run after validation
		do_action( 'cw_cf_after_validate', $clean );
	
		return $clean;
	
	}
	
	/**
	 * customizer function.
	 * 
	 * @since 0.1
	 * @access public
	 * @param mixed $wp_customize
	 * @return void
	 */
	function customizer($wp_customize){
		
		$cw_settings = get_option('cw_options');

		// Gets the unique option id
		if ( isset( $cw_settings['id'] ) ) {
		
			$option_name = $cw_settings['id'];
	
		} else {
		
			$option_name = 'cw_options';
	
		}

		$settings = get_option($option_name);
	
		$options = $this->options;

		$counter = 0;
	
		foreach ( $options as $value ) {

			$counter++;
		
			$name = $option_name.'['.$value['id'].']';
			
			//If capability isn't set default to edit_theme_options
			if( $value['capability'] == '' ){
				
				$capability = 'edit_theme_options';
				
			} else {
				
				$capability = $value['capability'];
				
			}
			
			
			switch ( $value['type']){
			
				case 'section':

					$wp_customize->add_section( $value['id'], array(
		  				'title'          => $value['title'],
		  				'description' 	 => $value['desc'],
		  				'priority'       => $value['priority'],
		  				'capability' 	 => $capability ,
		  				'theme_supports' => '',
		  				));
			
		 		break;
			
		 		case 'text':
			     
			    	$wp_customize->add_setting( $name , array(
			    		'default'		=> $value['default'],
			    		'type'			=> 'option',
			    		'capability'	=> $capability ,
			    		'theme_supports'=> $value['theme_supports'],
			    		) );
    
			    	$wp_customize->add_control( $name , array(
			    		'label'=> $value['label'],
			    		'section'=> $value['section'],
			    		'priority'=> $value['priority'],
			    		'settings'=> $name ,
			    		'type'=> 'text' ) );
			    		
			    break;
			    
			    case 'radio';
			    	$wp_customize->add_setting( $name, array(
			    		'default'		=> $value['default'],
			    		'type'			=> 'option',
			    		'capability'	=> $capability ,
			    		'theme_supports'=> $value['theme_supports'],
    			    		) );

			    	$wp_customize->add_control( $name , array(
			    		'label'=> $value['label'],
			    		'section'=> $value['section'],
			    		'priority'=> $value['priority'],
			    		'settings'=> $name ,
			    		'type' => 'radio',
			    		'choices' => $value['choices'],
			    		) );
			    break;
			    
			    case 'checkbox':
				
					$wp_customize->add_setting( $name , array(
			    		'default'		=> $value['default'],
			    		'type'			=> 'option',
			    		'capability'	=> $capability ,
			    		'theme_supports'=> $value['theme_supports'],
    			    		) );

				    $wp_customize->add_control( $name, array(
			    		'label'=> $value['label'],
			    		'section'=> $value['section'],
			    		'priority'=> $value['priority'],
			    		'settings'=> $name ,
						'type' => 'checkbox') );
			
				break;
		
				case 'select':
			    
					$wp_customize->add_setting( $name, array(
			    		'default'		=> $value['default'],
			    		'type'			=> 'option',
			    		'capability'	=> $capability ,
			    		'theme_supports'=> $value['theme_supports'],
    			    		) );

			    	$wp_customize->add_control( $name , array(
			    		'label'=> $value['label'],
			    		'section'=> $value['section'],
			    		'priority'=> $value['priority'],
			    		'settings'=> $name ,
			    		'type' => 'select',
			    		'choices' => $value['choices']) );
			    break;
			    
			    case 'color':
			    
			    	$wp_customize->add_setting($name , array(
			    		'default'		=> $value['default'],
			    		'type'			=> 'option',
			    		'capability'	=> $capability ,
			    		'theme_supports'=> $value['theme_supports'],
 			    		) );

			    	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, $value['id'], array(
			    		'label'=> $value['label'],
			    		'section'=> $value['section'],
			    		'priority'=> $value['priority'],
			    		'settings'=> $name ,
			    		'settings' => $name ,
			    	)));
			  
			    break;
			
			    case 'image':
			        
			        $wp_customize->add_setting( $name , array(
			    		'default'		=> $value['default'],
			    		'type'			=> 'option',
			    		'capability'	=> $capability ,
			    		'theme_supports'=> $value['theme_supports'],
 			    		) );

			        $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, $value['id'], array(
			    		'label'=> $value['label'],
			    		'section'=> $value['section'],
			    		'priority'=> $value['priority'],
			    		'settings'=> $name ,
			    		)));
			        	
			    break;
			    
			    case 'file':
			    	
			    	$wp_customize->add_setting( $name , array(
			    		'default'		=> $value['default'],
			    		'type'			=> 'option',
			    		'capability'	=> $capability ,
			    		'theme_supports'=> $value['theme_supports'],
 			    		) );

			        $wp_customize->add_control( new WP_Customize_Upload_Control($wp_customize, $value['id'], array(
			    		'label'=> $value['label'],
			    		'section'=> $value['section'],
			    		'priority'=> $value['priority'],
			    		'settings'=> $name ,
			    		)));
			    break;
			    
			    case 'dropdown-pages':
			 	
			 		$wp_customize->add_setting( $name , array(
			    		'default'		=> $value['default'],
			    		'type'			=> 'option',
			    		'capability'	=> $capability ,
			    		'theme_supports'=> $value['theme_supports'],
    			    		) );

				    $wp_customize->add_control( $name, array(
			    		'label'=> $value['label'],
			    		'section'=> $value['section'],
			    		'priority'=> $value['priority'],
			    		'settings'=> $name ,
						'type' => 'dropdown-pages') );
			    break;
			    
			    case 'textarea':
			        
			        $wp_customize->add_setting( $name , array(
			    		'default'		=> $value['default'],
			    		'type'			=> 'option',
			    		'capability'	=> $capability ,
			    		'theme_supports'=> $value['theme_supports'],
 			    		) );

			        $wp_customize->add_control( new CW_Textarea_Control($wp_customize, $value['id'], array(
			    		'label'=> $value['label'],
			    		'section'=> $value['section'],
			    		'priority'=> $value['priority'],
			    		'settings'=> $name ,
			    		)));
			        	
			    break;
			    
			}//end switch
	
		}//End for each
			
	}

}//end class

add_action('init', 'cw_cf_init');

/**
 * Initizalizes the class
 * 
 * @access public
 * @return void
 */
function cw_cf_init(){
	
	$cw_customizer = new cw_Customizer();

}

endif;//end if class exists.

if ( ! function_exists('cw_theme_option')) {
/**
 * Get the option.
 * 
 * @access public
 * @param mixed $option
 * @param bool $default (default: false)
 * @return void
 */
function cw_theme_option(  $option , $default = false ){

	$config = get_option( 'cw_options' );

	if ( ! isset( $config['id'] ) ) {
	
		return $default;
	
	}

	$options = get_option( $config['id'] );

	if ( isset( $options[$option] ) ) {
	
		return $options[$option];
		
	}

	return $default;
	
}
}

if ( ! function_exists('cw_version_compare')){
/**
 * Version Compare function, compares current version with $version .
 * 
 * @access public
 * @param mixed $version
 * @return void
 */
function cw_version_compare( $version ){

	global $wp_version;
	
	if( version_compare( $wp_version, $version , '>=' )  ){
		
		return true;
		
	} else {
		
		return false;
	
	}
	
}
}//end function exists

?>