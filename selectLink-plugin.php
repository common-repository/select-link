<?php
/*
Plugin Name: Select Link
Plugin URI: https://www.ceeglo.se/csl.php
Description: With this plugin you can in a simple way create your own dropdown with custom links.
Author: Ceeglo
Author URI: https://www.ceeglo.se
Version: 1.0


*/


add_shortcode("cslSelect", array( cSelectLink::get_instance(), 'cSelectLinkSelect' ));
add_shortcode("cslOption",array( cSelectLink::get_instance(), 'cSelectLinkOption' ));
class cSelectLink {

    protected static $instance = NULL;

    public static function get_instance() {
        NULL === self::$instance and self::$instance = new self;
        return self::$instance;
    }

    function cSelectLinkSelect($attr,$content){
      $title = sanitize_text_field($attr["title"]);
      $data  = '<select name="c-links" id="c-links">';
      $data .= '<option value="0" selected disabled>'.esc_html($title).'</option>';
      $data .= ''.do_shortcode($content);
      $data .= '</select>';
      $data .= "
      <script>
      jQuery('#c-links').change(function(){
          var link = jQuery(this).val();
          window.location.href = link;
      });
      </script>
      ";

      return $data;
    }

    function cSelectLinkOption($attr,$content){
      $content      = sanitize_text_field($content);
      $attr["url"]  = sanitize_text_field($attr["url"]);
      return '<option value="'.esc_url($attr["url"]).'">'.esc_html($content).'</option>';
    }

}


add_action("admin_menu", "cSLaddMenu");
function cSLaddMenu()
{
  add_menu_page("Select Link", "Select Link", 4, "cSL", "cSLDashboard");
  add_submenu_page("cSL", "Select Link - Hjälp", "Help", 4, "cSLHelp", "cSLHelp");
}

function cSLDashboard()
{
  echo '<h3>Select Link</h3>';
  echo '<div class="card col-12">';
  echo '<p>In order to use this plugin use the shortcode below:</p>';
  echo '<b>Example</b>: <pre><code>[cslSelect title="Title for your dropdown"]

[cslOption url="https://ceeglo.se"] Ceeglo Homepage [/cslOption]

[cslOption url="https://www.google.se"] Google [/cslOption]

[/cslSelect]</code></pre>';
echo '</div>';
}

function cSLHelp()
{
  echo '<h3>Help</h3>';
  echo '<div class="row card card-body col-12">';
  echo '<p>Having problems? We are happy to help, contact us at <a href="mailto:chris@ceeglo.se">chris@ceeglo.se</a> </p>';
  echo '</div>';
}
