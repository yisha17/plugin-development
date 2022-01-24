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

        
        # if both page and post selected

        if (get_option('psp_post') == '1' AND get_option('psp_page') != '1'  ){
            $this->debug_to_console("number 1");
            if(is_single()){
                $this->addHTML($content);
            }else{
                return $content;
            }
        }
        if (get_option('psp_post','1') == '1' AND get_option('psp_page','1') == '1' ){
            $this->debug_to_console("number 2");
            if(is_singular()){
                $this->addHTML($content);
            }
        }
       
        if ((get_option('psp_post','1') != '1') AND (get_option('psp_page','1') == '1' )){
            $this->debug_to_console("number 3");
            if(is_page()){
                $this->addHTML($content);
            }
        }
        if ((get_option('psp_post','1') != '1') AND (get_option('psp_page','1') != '1' )){
            $this->debug_to_console("number 4");
            return $content;
        }
        return $content;
    }

    function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

    function chooseType($content){
         if (get_option('psp_type','0') == '0'){
            $html = include_once plugin_dir_path(__FILE__) .'includes/verticalL.php';
            wp_enqueue_style( 'myCSS', plugin_dir_url(__FILE__) .'assets/css/vertical.css');
            wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) .'assets/js/vertical.js');
            return $content.$html;
        }elseif(get_option('psp_type','1') == '1'){
            $html = include_once plugin_dir_path(__FILE__) .'includes/vertical.php';
            wp_enqueue_style( 'myCSS', plugin_dir_url(__FILE__) .'assets/css/vertical.css');
            wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) .'assets/js/vertical.js');
            return $content.$html;
        }elseif(get_option('psp_type','2') == '2'){
            $html = include_once plugin_dir_path(__FILE__) .'includes/horizontal.php';
            wp_enqueue_style( 'myCSS', plugin_dir_url(__FILE__) .'assets/css/horizontal.css');
            wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) .'assets/js/horizontal.js');
            return $content.$html;
        }elseif(get_option('psp_type','3') == '3'){
            $html = include_once plugin_dir_path(__FILE__) .'includes/circle.php';
            wp_enqueue_style( 'myCSS', plugin_dir_url(__FILE__) .'assets/css/style.css');
            wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) .'assets/js/script.js');
            return $content.$html;
        }
        
        return $content;
    }

    function addHTML($content){
        if (get_option('psp_post') == '1' AND get_option('psp_page') != '1'  ){
            if(is_single()){
                $this->chooseType($content);
            }else{
                return $content;
            }
        }
        if (get_option('psp_post','1') == '1' AND get_option('psp_page','1') == '1' ){
            $this->debug_to_console("number 2");
            if(is_singular()){
                $this->chooseType($content);
            }
        }
         if ((get_option('psp_post','1') != '1') AND (get_option('psp_page','1') == '1' )){
            $this->debug_to_console("number 3");
            if(is_page()){
                $this->chooseType($content);
            }
        }
        if ((get_option('psp_post','1') != '1') AND (get_option('psp_page','1') != '1' )){
            $this->debug_to_console("number 4");
            return $content;
        }
        
       
    }

    function settings(){
        add_settings_section('psp_first_section','Choose Scroll Type',null,'page-scroll-setting');
        add_settings_section('psp_second_section','Choose Scroll Location',null,'page-scroll-setting');

        add_settings_field('psp_type','Page Scroll Progress Type',array($this,'typeHTML'),'page-scroll-setting','psp_first_section');
        register_setting('progressplugin','psp_type',array('sanitize_callback'=> array($this,'sanitizeType'),'default'=> '3'));

        add_settings_field('psp_post',null,array($this,'postHTML'),'page-scroll-setting','psp_second_section');
        register_setting('progressplugin','psp_post',array('sanitize_callback'=> 'sanitize_text_field','default'=> '1'));

        add_settings_field('psp_page',null,array($this,'pageHTML'),'page-scroll-setting','psp_second_section');
        register_setting('progressplugin','psp_page',array('sanitize_callback'=> 'sanitize_text_field','default'=> '1'));
    }

    function sanitizeType($input){

        if($input != '0' AND $input != '1' AND $input != '2' AND $input != '3' AND $input != '4' ){
           add_settings_error( 'psp_type', 'psp_type_error','Incorrect type of progress bar.'); 
           return get_option('psp_type');
        }
        return $input;
    }

    function postHTML(){?>
        <input type="checkbox" name="psp_post" value="1" <?php checked(get_option('psp_post'),'1')  ?>>Posts</input><br>
    <?php }

    function pageHTML(){?>
        <input type="checkbox" name="psp_page" value="1" <?php checked(get_option('psp_page'),'1')  ?>>Pages</input><br>
    <?php }

    function typeHTML(){?>
        
        <input type="radio" name="psp_type" value="0"  <?php checked(get_option('psp_type'),'0');?>>
        <label >Vertical Linear Progress Bar Left Side</label><br>
        <input type="radio" name="psp_type" value="1"  <?php checked(get_option('psp_type'),'1');?>>
        <label >Vertical Linear Progress Bar Both Side</label><br>
        <input type="radio"  name="psp_type" value="2" <?php checked(get_option('psp_type'),'2') ?>>
        <label >Horizontal Linear Progress Bar</label><br>
        <input type="radio" name="psp_type" value="3"  <?php checked(get_option('psp_type'),'3') ?>>
        <label >Circular Progress Bar</label><br>
        <input type="radio" name="psp_type" value="4"  <?php checked(get_option('psp_type'),'4') ?>>
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
