<?php
/*
Plugin Name: Quizz Contest
Plugin URI: http://monsite.fr/plugins/quizzcontest
Description: Quizz contest
Version: 0.1
Author: Le Sanglier des Ardennes
Author URI: http://steamcyberpunk.net/
License: GPL2 license
*/

/*
Initialize/install or uninstall
*/

/* 
Runs when plugin is activated 
*/
register_activation_hook(__FILE__,'quizzcontest_install'); 

/* 
Runs on plugin deactivation
*/
register_deactivation_hook( __FILE__, 'quizzcontest_remove' );

/* 
The quizzcontest_data field is created in wp_options table
Creates new database field 
*/
function quizzcontest_install() {
    add_option("quizzcontest_data", 'Default', '', 'yes');
}

/* Deletes the database field */
function quizzcontest_remove() {
    delete_option('quizzcontest_data');
}

/*
Display administration page
*/
if ( is_admin() ){
    function quizzcontest_menu(){
         add_options_page('Quizz Contest', 'Quizz Contest', 'administrator', basename(__FILE__), 'quizzcontest_option');
    }

    add_action('admin_menu','quizzcontest_menu');

    function quizzcontest_option(){
         include('admin/quizzcontest_option.php');
    } 
}

/*
Add stylesheet and javascript in header
*/
function addHeader() {
   print '<link media="screen" type="text/css" href="/wp-content/plugins/quizzcontest/css/style.css" rel="stylesheet">';
   print '<script type="text/javascript" src="/wp-content/plugins/quizzcontest/js/main.js"></script>';
}
add_action('wp_head', 'addHeader');

/*
Shortcut : [quizzcontest_shortcode]
*/
function displayQuizzContestShortCode() {
    $default_quizzcontest = "
        Le concours :  <br/>
        <span class='quizzcontest_title'> " . get_option('quizzcontest_data'). " </span> <br/>
        Bonne chance !! <br/>
    ";
    return apply_filters('quizzcontest', $default_quizzcontest);
}
add_shortcode( 'quizzcontest_shortcode', 'displayQuizzContestShortCode' );

/*
 Display a notice on top of the dashboard
*/
function displayAdminNotice(){
    echo "
    <p>
    Admin alert in dashboard
    </p>";
}
//add_action('admin_notices', 'displayAdminNotice');

/*
Display a text after a post in view post
*/
function displayTextAfterPost($content) {

 if ( is_single() ) {
    $content .= "
        <br/>
        <span class='quizzcontest_title'> " . get_option('quizzcontest_data'). " </span>
        ";
 }

  return $content;
}
//add_filter('the_content', 'displayTextAfterPost');
?>
