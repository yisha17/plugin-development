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
        
    }

    function adminPage(){
        add_options_page('page scroll setting','page_scroll','manage_options','page-scroll-setting',array($this,'addLayout'));
    }

    function addLayout(){?>
        <div class="wrap">
            <h1>Page Scroll Settings</h1>
        </div>
    <?php }
}

    $plugin = new PageScrollPercentage();
?>
