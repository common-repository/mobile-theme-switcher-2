<?php 

mts2_set_lang_file();

/*
function mts2_set_lang_file() {
	# set the language file
	$currentLocale = get_locale();
	if(!empty($currentLocale)) {
		$moFile = dirname(__FILE__) . "/lang/" . $currentLocale . ".mo";
		if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('mts2', $moFile);
	}
}
*/




/**
 * Display the plugin settings options page
 */

    $settings_api = WeDevs_Settings_API::getInstance();
 
    echo '<div class="wrap">';
	echo '<h2><a href="'.MTS2_AUTHOR_URI.'" target="_blank">' . __( 'MTS2 - Mobile Theme Switcher 2', 'mts2' ) .'</a></h2>'."\n";
    settings_errors();
 
    $settings_api->show_navigation();
    $settings_api->show_forms();
 
    echo '</div>';

	
	

?>