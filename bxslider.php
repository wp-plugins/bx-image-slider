<?php
/**
* Plugin Name:Bx slider
* Plugin URI: anjitvishwakarma28.wordpress.com
* Description: this plugin use to make carrosal.
* Version: 1.1
* Author: Anjit Vishwakarma
* Author URI:anjitvishwakarma28.wordpress.com
* License: GPL2
*/
// Add Shortcode
add_action( 'admin_menu', 'p_init' );

function p_init(){
add_menu_page('Bx_slider', "Bx Slider", "manage_options", "bxsliders", "bxsliders",plugins_url('ico.png',__FILE__),"4");

add_action( 'admin_init', 'update_bxsliders' );
}

function bxslider( $atts ) { 
// Attributes 
extract( shortcode_atts( 
array( 'title' =>'',
'image' =>'',
'description' =>''
)
, $atts )); 
// Code 

if(!empty($atts)):
$atts=array('title'=>explode(',',$atts[title]),'image'=>explode(',',$atts[image]),'description'=>explode(',',$atts[description]));

echo '<ul class="bxslider"> ';
$i=0;
foreach ($atts['image'] as $loop):


if($atts['image'][$i]){
echo '
<li><img src="';echo $atts['image'][$i];echo '" />';
}

if($atts['title'][$i]){
echo '<h3>';
echo $atts['title'][$i];
echo '</h3>'; 
}

if($atts['description'][$i]){
echo '<p>';
echo $atts['description'][$i];
echo '</p>';
}
echo '</li>';
$i++;
endforeach;
echo '
</ul>'; 
endif;
} 
add_shortcode( 'bx_Slider', 'bxslider' );

function bx_scripts_method() {
wp_enqueue_style( 'bxslider',plugins_url('jquery.bxslider.css',__FILE__));
wp_enqueue_script( 'bxsliderjs',plugins_url('/jquery.bxslider.js',__FILE__));
}
add_action( 'wp_footer', 'bx_scripts_method' );
if( !function_exists("update_bxsliders") )
{
function update_bxsliders() {
  register_setting( 'bxsliders-settings', 'bpager' );
  register_setting( 'bxsliders-settings',  'bcontrols');
  register_setting( 'bxsliders-settings',  'binfiniteLoop' );
  register_setting( 'bxsliders-settings',  'bautoStart');
}
}
 
if(isset($_REQUEST["submit"])){ 
    update_option('bpager',sanitize_text_field($_REQUEST['bpager']));    
    update_option('bcontrols',sanitize_text_field($_REQUEST['bcontrols']));    
    update_option('binfiniteLoop',sanitize_text_field($_REQUEST['binfiniteLoop']));    
    update_option('bautoStart',sanitize_text_field($_REQUEST['bautoStart']));    
    echo '<div id="message" class="updated fade"><p>Options Updates</p></div>';
}
function bxsliders(){
?>
<h1>Bx Slider</h1>
<p>This slider give you advantage to show slider with use of shortcode:</p><p>
[bx_Slider title='' image='urls of image' description='']</p>
<p> Add titles, images, descriptions in Comma seprated sting like:
title1,title2......,titlen</p>
<h2>Settings</h2>
<form method="post" action="options.php" >
 <?php settings_fields( 'bxsliders-settings' ); ?>
 <?php do_settings_sections( 'bxsliders-settings' ); ?>
  <div class="form-group">
  <table class="form-table">
<tbody><tr>
<th scope="row">Default Slider settings</th>
<td><fieldset><legend class="screen-reader-text"><span>Default Slider settings</span></legend>
<label>
<input type="checkbox" class="form-control" name="bcontrols" value="true" <?php if(get_option( 'bcontrols' )):?> checked <?php endif;?> >
controls</label>
<br>
<label>
 <input type="checkbox" class="form-control"   name="binfiniteLoop" value="true" <?php if(get_option( 'binfiniteLoop' )):?> checked <?php endif;?> >
infiniteLoop</label>
<br>
<label>
 <input type="checkbox" class="form-control"   name="bautoStart" value="true" <?php if(get_option( 'bautoStart' )):?> checked <?php endif;?> >
autoStart</label>
<br>
<label>
<input type="checkbox" class="form-control"  name="bpager" value="true" <?php if(get_option( 'bpager' )):?> checked <?php endif;?> />
pager</label>
<br>
<p class="description">(These settings may be overrid the default settings.)</p>
</fieldset></td>
</tr>
</tr>
</tbody>
</table>
 <?php submit_button(); ?>
</form>
</div>
<?php
}
add_action( 'wp_footer', 'bx_footer_script', 100 );
function bx_footer_script(){
  ?>
  <script>
  jQuery(document).ready(function(){
  jQuery('.bxslider').bxSlider({
<?php if(get_option( 'bpager' )):?>
 pager: true,
<?php else: ?>
 pager: false,
<?php endif;?> 
<?php if(get_option( 'bcontrols' )):?>    
 controls: true,
<?php else: ?>
 controls: false, 
<?php endif;?>      
<?php if(get_option( 'binfiniteLoop' )):?>   
infiniteLoop:true,
<?php endif;?>      
<?php if(get_option( 'bautoStart' )):?>      
auto:true,
<?php endif;?>      
    });
});
  </script>
  <?php
}