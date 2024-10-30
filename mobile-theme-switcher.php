<?php
/*
Plugin Name: MTS2 - Mobile Theme Switcher 2
Plugin URI: http://wordpress.org/extend/plugins/mobile-theme-switcher-2/
Description: Detects if site is being viewed by a mobile browser and switches to a different theme of your choice.
Version: 0.3
Author: Juergen Schulze
Author URI: http://1manfactory.com/mts2
License: GNU GP
*/

/*  Copyright 2013 Juergen Schulze, 1manfactory.com (email : 1manfactory@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


// Version/Build of the plugin
define( 'MTS2_CURRENT_VERSION', '0.1' );
define( 'MTS2_CURRENT_BUILD', '10' );
define( 'MTS2_AUTHOR_URI', 'http://1manfactory.com/mts2' );

// using external class by Tareq Hasan http://tareq.wedevs.com/2012/06/wordpress-settings-api-php-class/
require('class.settings-api.php');


mts2_set_lang_file();
add_action('admin_menu', 'mts2_admin_actions');
add_action('setup_theme', 'MTS2_switch', -1 );
add_action('admin_init', 'MTS2_init');

# get all the installed theme's information
$all_the_themes=get_themes();
//print_r($all_the_themes);die();


# define what we are searching for

$sections = array(
	array(
		'id' => 'mts2_basics',
		'title' => __( 'Settings', 'mts2' )
	)
);

$fields = array(
	'mts2_basics' => array(
		array(
			'name' => 'iPad',
			'needle' => 'iPad',
			'label' => __( 'Mobile Theme for iPad', 'mts2' ),
			'desc' => __( 'Mobile Theme for iPad (Tablet)', 'mts2' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				//'yes' => 'Yes',
				//'no' => 'No'
			)
		),
		array(
			'name' => 'iPod',
			'needle' => 'iPod',
			'label' => __( 'Mobile Theme for iPod', 'mts2' ),
			'desc' => __( 'Mobile Theme for iPod', 'mts2' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				//'yes' => 'Yes',
				//'no' => 'No'
			)
		),
		array(
			'name' => 'iPhone',
			'needle' => 'iPhone',
			'label' => __( 'Mobile Theme for iPhone', 'mts2' ),
			'desc' => __( 'Mobile Theme for iPhone (Smartphone)', 'mts2' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				//'yes' => 'Yes',
				//'no' => 'No'
			)
		),
		array(
			'name' => 'blackberry',
			'needle' => 'BlackBerry',
			'label' => __( 'Mobile Theme for Blackberry', 'mts2' ),
			'desc' => __( 'Mobile Theme for Blackberry (Smartphone)', 'mts2' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				//'yes' => 'Yes',
				//'no' => 'No'
			)
		),
		array(
			'name' => 'opera mini',
			'needle' => 'Opera Mini',
			'label' => __( 'Mobile Theme for Opera Mini', 'mts2' ),
			'desc' => __( 'Mobile Theme for Opera Mini', 'mts2' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				//'yes' => 'Yes',
				//'no' => 'No'
			)
		),
		array(
			'name' => 'Kindle',
			'needle' => 'Kindle [^Fire]',
			'label' => __( 'Mobile Theme for Kindle', 'mts2' ),
			'desc' => __( 'Mobile Theme for Kindle (not Kindle Fire!)', 'mts2' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				//'yes' => 'Yes',
				//'no' => 'No'
			)
		),
		array(
			'name' => 'Kindle Fire',
			'needle' => 'Kindle Fire',
			'label' => __( 'Mobile Theme for Kindle Fire', 'mts2' ),
			'desc' => __( 'Mobile Theme for Kindle Fire', 'mts2' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				//'yes' => 'Yes',
				//'no' => 'No'
			)
		),			
		array(
			'name' => 'palm',
			'needle' => 'palm',
			'label' => __( 'Mobile Theme for Palm OS', 'mts2' ),
			'desc' => __( 'Mobile Theme for Palm OS', 'mts2' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				//'yes' => 'Yes',
				//'no' => 'No'
			)
		),
		array(
			'name' => 'Windows Phone',
			'needle' => 'Windows Phone',
			'label' => __( 'Mobile Theme for Windows Phone', 'mts2' ),
			'desc' => __( 'Mobile Theme for Windows Phone', 'mts2' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				//'yes' => 'Yes',
				//'no' => 'No'
			)
		),			
		array(
			'name' => 'AndroidSmartphones',
			'needle' => 'Android.*Mobile',
			'label' => __( 'Mobile Theme for Android Smartphones', 'mts2' ),
			'desc' => __( 'Mobile Theme for Android Smartphones (not Tablets!)', 'mts2' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				//'yes' => 'Yes',
				//'no' => 'No'
			)
		)
	),
);

// fill array with avaiable themes
//$themes = get_themes();
//$all_the_themes
foreach ($fields["mts2_basics"] as $k=>$array_element) {
	//echo $array_element['name'];
	//foreach ($array_element["options"] as $array_element2) {
		//print $array_element2;
		$fields["mts2_basics"][$k]["options"]=$all_the_themes;
	//}
}


function MTS2_switch() {
	session_start();

	global $found_theme, $user_agent_string, $fields;
	
	
	if($_GET['mobile'] == "off"){
		$_SESSION[$usermobileoff] = true; 
	} else if($_GET['mobile'] == "on"){
		$_SESSION[$usermobileoff] = false;
	}

	// detect mobile browsers
	$user_agent_string=$_SERVER['HTTP_USER_AGENT'];
	//$user_agent_string="Android";
	//$user_agent_string="iPad";
	//die($user_agent_string);
	$options = get_option("mts2_basics");

	//die($user_agent_string);
	$options = get_option("mts2_basics");
	//print_r($user_agent_string);die('');
	
	//print_r($fields["mts2_basics"]);
	
	// only check if not forced
	if (!$_SESSION[$usermobileoff]) {
		$i=0;
		foreach ($options as $key=>$value) {
			//print $key."=>".$value."<br>";
			//print "needle:>".$fields["mts2_basics"][$i]['needle']."<<br>";
			//if (preg_match('/'.$key.'/i',$user_agent_string)) {
			if (preg_match('/'.$fields["mts2_basics"][$i]['needle'].'/i',$user_agent_string)) {
				$found_theme=$value;
				add_filter('template', 'getTemplateTheme');
				add_filter('stylesheet', 'getTemplateStyle');
				break;
			}
			$i++;
		}
	}
}

// set all variables und arrays we will need
function MTS2_init() {
 
	global $fields, $sections;
 

	
 
 
    $settings_api = WeDevs_Settings_API::getInstance();
 
    //set sections and fields
    $settings_api->set_sections( $sections );
    $settings_api->set_fields( $fields );
 
    //initialize them
    $settings_api->admin_init();
	
	
}
	




/**
* Plugin deactivation
*/
register_deactivation_hook( __FILE__, 'MTS2_plugin_deactivation' );
function MTS2_plugin_deactivation() {
	// nothing right now. we will keep option in store
}

// uninstall
register_uninstall_hook (__FILE__, 'MTS2_uninstall');
function MTS2_uninstall() {
	# delete all data stored by MTS2
	delete_option('MTS2_mobiletheme');

}

function getTemplateTheme(){
	global $found_theme, $user_agent_string, $all_the_themes;
	//die ($user_agent_string);
	//die(print_r($themes));
	foreach ($all_the_themes as $theme_data) {
		if ($theme_data['Name'] == $found_theme) {
			return $theme_data['Template'];
		}
	}
}

function getTemplateStyle(){
	global $found_theme, $user_agent_string, $all_the_themes;
	//die ($user_agent_string);
	//$themes = get_themes();
	//die(print_r($themes));

	foreach ($all_the_themes as $theme_data) {
		if ($theme_data['Name'] == $found_theme) {
			return $theme_data['Stylesheet'];
		}
	}
}


function mts2_admin_actions() { 
	if (current_user_can('manage_options'))  {
		add_theme_page(__( 'MTS2 - Mobile Theme Switcher 2', 'mts2' ), "Mobile&nbsp;Theme&nbsp;Switcher", 'manage_options', "mobile-theme-switcher-2", "mts2_show_admin");
	}
} 

function mts2_show_admin(){
	include('mobile-theme-switcher-admin.php'); 
}


// validate our options
function mts2_options_validate($input) {
	print_r($input);
}

/**
 * Get the value of a settings field
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 * @return mixed
 */
function mts2_get_option( $option, $section, $default = '' ) {
 
    $options = get_option( $section );
 
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
 
    return $default;
}

/**
 * Get the value of a settings field
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 * @return mixed
 */
function my_get_option( $option, $section, $default = '' ) {
 
    $options = get_option( $section );
 
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
 
    return $default;
}

function mts2_set_lang_file() {
	# set the language file
	$currentLocale = get_locale();
	if(!empty($currentLocale)) {
		$moFile = dirname(__FILE__) . "/lang/" . $currentLocale . ".mo";
		if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('mts2', $moFile);
	}
}

?>