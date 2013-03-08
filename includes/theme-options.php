<?php

/**
 * cw_customizer_options function.
 * 
 * @since 0.1
 * @access public
 * @return array
 */
function cw_customizer_options() {

	// Pagination Array
	$sample_array = array(
		'test1' => __('Test One', 'cw'),
		'test2' => __('Test Two', 'cw')
	);

	$options = array();

	/* Section Settings
	*  The setting section is a little different than setting up the other controls
	*/
	$options[] = array(
		'type' => 'section',
		'id' => 'cw_general',
		'title' => __('General', 'cw'),
		'desc' => __('This is my general settings description', 'cw'),//displays as a tooltip on hover
		'priority' => '35',
		'capability' => 'edit_theme_options',
		'theme_supports' => '',);
	
	//Text Setting
	$options[] = array(
		'type' => 'text',
		'id' => 'cw_text',
		'section' => 'cw_general',// This is the section the fields go in.
		'priority' => '1',
		'capability' => 'edit_theme_options',
		'label' => __('This is a sample Textarea', 'cw'),
		'default' => 'Read more',
		'theme_supports' => '',
		'transport' => '',// this is the default
		);
	
	//Textarea
	$options[] = array(
		'type' => 'textarea',
		'id' => 'cw_textarea',
		'section' => 'cw_general',
		'priority' => '2',
		'capability' => 'edit_theme_options',
		'label' => __('Textarea Test', 'cw_theme'),
		'default' => 'This is a textarea test',
		'theme_supports' => '',
		'transport' => '',// this is the default
		);
	
	//Checkbox Setting
	$options[] = array(
		'type' => 'checkbox',
		'id' => 'cw_checkbox',
		'section' => 'cw_general',
		'priority' => '3',
		'capability' => 'edit_theme_options',
		'label' => __('This is a sample checkbox', 'cw'),
		'default' => '0',// 0 or 1
		'theme_supports' => '',
		'transport' => '',// refresh (default) or postMessage 
		);
	
	//Radio
	$options[] = array(
		'type' => 'radio',
		'id' => 'cw_radio',
		'section' => 'cw_general',
		'priority' => '4',
		'capability' => 'edit_theme_options',
		'label' => __('Radio Test', 'cw_theme'),
		'default' => 'test1',
		'theme_supports' => '',
		'transport' => '',// this is the default
		'choices' => $sample_array,
		);
	//Color
		$options[] = array(
		'type' => 'color',
		'id' => 'cw_color',
		'section' => 'cw_general',
		'priority' => '5',
		'capability' => 'edit_theme_options',
		'label' => __('Color Test', 'cw_theme'),
		'default' => '#000000',
		'theme_supports' => '',
		'transport' => '',// this is the default
		);
		
	//Custom Select
	$options[] = array(
		'type' => 'select',
		'id' => 'cw_select',
		'section' => 'cw_general',
		'priority' => '6',
		'capability' => 'edit_theme_options',
		'label' => __('Select Test', 'cw_theme'),
		'default' => 'test1',
		'theme_supports' => '',
		'transport' => '',// this is the default
		'choices' => $sample_array,
		);
		
	//Image Upload
	$options[] = array(
		'type' => 'image',
		'id' => 'cw_image',
		'section' => 'cw_general',
		'priority' => '7',
		'capability' => 'edit_theme_options',
		'label' => __('Image Test', 'cw_theme'),
		'default' => '',
		'theme_supports' => '',
		'transport' => '',// this is the default
		);
		
	//File Upload
	$options[] = array(
		'type' => 'file',
		'id' => 'cw_file',
		'section' => 'cw_general',
		'priority' => '8',
		'capability' => 'edit_theme_options',
		'label' => __('File Test', 'cw_theme'),
		'default' => '',
		'theme_supports' => '',
		'transport' => '',// this is the default
		);
		
	//Page Dropdown
	$options[] = array(
		'type' => 'dropdown-pages',
		'id' => 'cw_pages',
		'section' => 'cw_general',
		'priority' => '9',
		'capability' => 'edit_theme_options',
		'label' => __('Dropdown Pages', 'cw'),
		'default' => '0',// 0 or 1
		'theme_supports' => '',
		'transport' => '',// refresh (default) or postMessage 
		);
	
	return $options;
}

?>