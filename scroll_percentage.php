<?php
/**
 * Plugin Name:       Page Scroll Percentage
 * Plugin URI:        https://contactform.com
 * Description:       A simple plugin thay shows the percentage of page scrolled
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Yishak W.
 * Author URI:        https://fa.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 */

class PageScrollPercentage{

    function __construct(){
        add_action('admin_menu',array($this,'adminPage'));
        add_action('admin_init',array($this,'settings'));
    }

    function settings(){
        add_settings_section('psp_first_section','Choose Scroll Type',null,'page-scroll-setting');
        add_settings_field('psp_type','Page Scroll Progress Type',array($this,'typeHTML'),'page-scroll-setting','psp_first_section');
        register_setting('progressplugin','psp_type',array('sanitize_callback'=> 'sanitize_text_field','default'=> '0'));
    }


    function typeHTML(){?>

        <input type="radio" name="psp_type" value="0">
        <label >Vertical Linear Progress Bar</label><br>
        <input type="radio"  name="psp_type" value="1">
        <label >Horizontal Linear Progress Bar</label><br>
        <input type="radio" name="psp_type" value="2">
        <label >Circular Progress Bar</label>
    <?php }

    function adminPage(){
        add_options_page('page scroll setting','Scroll Setting','manage_options','page-scroll-setting',array($this,'addLayout'));
    }

    function addLayout(){?>
        <div class="wrap">
            <h1>Page Scroll Settings</h1>
            <form action="options.php" method="POST">
                <?php
                    settings_fields('progressplugin');
                    do_settings_sections('page-scroll-setting');
                    submit_button();
                ?>
            </form>
        </div>
    <?php }
}

    $plugin = new PageScrollPercentage();
?>
