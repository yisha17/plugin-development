<?php
/**
 * Plugin Name:       Page Scroll Percentage
 * Plugin URI:        https://github.com/yisha17/plugin-development
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
        add_filter('the_content',array($this,'wrapPost'));
        add_action('wp_enqueue_scripts',array($this,'addHTML'));
    }

    function wrapPost($content){

        if( is_page() OR is_single()){
            return $this-> addHTML($content);
        }
        return $content;
    }



    function addHTML($content){
        $html = include_once plugin_dir_path(__FILE__) .'includes/horizontal.php';
        wp_enqueue_style( 'myCSS', plugin_dir_url(__FILE__) .'assets/css/horizontal.css');
        wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'assets/js/horizontal.js' );

        return $content.$html;
    }

    function settings(){
        add_settings_section('psp_first_section','Choose Scroll Type',null,'page-scroll-setting');
        add_settings_section('psp_second_section','choose page or post',null,'page-scroll-setting');

        add_settings_field('psp_type','Page Scroll Progress Type',array($this,'typeHTML'),'page-scroll-setting','psp_first_section');
        register_setting('progressplugin','psp_type',array('sanitize_callback'=> array($this,'sanitizeType'),'default'=> '3'));

        add_settings_field('psp_location','location',array($this,'locationHTML'),'page-scroll-setting','psp_second_section');
        register_setting('progressplugin','psp_location',array('sanitize_callback'=> 'sanitize_text_field','default'=> '1'));
    }

    function sanitizeType($input){

        if($input != '0' AND $input != '1' AND $input != '2' ){
           add_settings_error( 'psp_type', 'psp_type_error','Incorrect type of progress bar.'); 
           return get_option('psp_type');
        }
        return $input;
    }

    function locationHTML(){?>
        <input type="checkbox" name="psp_location" value="1"<?php checked(get_option('psp_location'),'1')  ?>>Pages</input><br>
        <input type="checkbox" name="psp_location" value="1"<?php checked(get_option('psp_location'),'0')  ?>>Posts</input>
    <?php }

    function typeHTML(){?>
        
        <input type="radio" name="psp_type" value="0"  <?php checked(get_option('pcp_type'),'0');?>>
        <label >Vertical Linear Progress Bar</label><br>
        <input type="radio"  name="psp_type" value="1" <?php checked(get_option('pcp_type'),'1') ?>>
        <label >Horizontal Linear Progress Bar</label><br>
        <input type="radio" name="psp_type" value="2"  <?php checked(get_option('pcp_type'),'2') ?>>
        <label >Circular Progress Bar</label><br>
        <input type="radio" name="psp_type" value="3"  <?php checked(get_option('pcp_type'),'3') ?>>
        <label >None</label>


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
