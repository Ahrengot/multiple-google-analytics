<?php
/*
Plugin Name: Multiple Google Analytics Trackers
Plugin URI: https://github.com/Ahrengot/multiple-google-analytics
Description: Minimal Google Analytics plugin that let's you set up multiple trackers and fully control when and where the analytics script is rendered.
Version: 1.1.1
Author: Jens Ahrengot Boddum
Author URI: http://ahrengot.com/
Text Domain: multi-google-analytics
Domain Path: /lang
License: GPL v3
*/

class AhrGoogleAnalytics {

  const PLUGIN_NAME = 'ahr-google-analtyics';
  const OPTIONS_PAGE_SLUG = 'google-analytics';

  const OPTION_IDS = 'ahr_ga_ids';
  const OPTION_LOCATION = 'ahr_ga_location';

  public function __construct() {
    add_action('plugins_loaded', function() {
      load_plugin_textdomain( 'multi-google-analytics', false, basename( dirname( __FILE__ ) ) . '/lang/' );
    });
    $this->init();
  }

  private function init() {
    register_activation_hook( __FILE__, array($this, 'on_activate_plugin') );
    register_deactivation_hook( __FILE__, array($this, 'on_deactivate_plugin') );

    add_action( 'admin_init', array($this, 'register_settings'), 10 );
    add_action( 'admin_menu', array($this, 'add_menu_item'), 10 );
    add_action( 'admin_notices', array($this, 'maybe_render_ga_id_notice') );

    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_action_links'), 10, 1 );

    add_action( 'admin_enqueue_scripts', array($this, 'load_assets') );

    // If frontend, add hooks for printing GA script
    if ( !is_admin() ) {
      add_action( get_option( self::OPTION_LOCATION ), array($this, 'add_analytics_script'), 50 );
    }
  }

  public function on_activate_plugin() {
    // Set default ga script location
    if ( !get_option( self::OPTION_LOCATION ) ) {
      update_option( self::OPTION_LOCATION, 'wp_footer' );
    }

    // Set default value for analytics ids
    if ( !get_option( self::OPTION_IDS ) ) {
      update_option( self::OPTION_IDS, array() );
    }
  }

  public function plugin_action_links($links) {
    $links[] = sprintf(
      __( '<a href="%s">Settings</a>', 'multi-google-analytics' ),
      admin_url( 'options-general.php?page=' . AhrGoogleAnalytics::OPTIONS_PAGE_SLUG )
    );

    return $links;
  }

  public function maybe_render_ga_id_notice() {
    $screen = get_current_screen();
    if ( 'plugins' === $screen->base && !get_option( self::OPTION_IDS ) ) {
      include_once 'admin/activation-notice.php';
    }
  }

  public function on_deactivate_plugin() {
    remove_action( 'admin_notices', array($this, 'maybe_render_ga_id_notice') );
  }

  public function register_settings() {
    register_setting( self::PLUGIN_NAME, self::OPTION_IDS, array($this, 'validate_ua_string') );
    register_setting( self::PLUGIN_NAME, self::OPTION_LOCATION );
  }

  public function add_menu_item() {
    add_options_page(
      __('Google Analytics', 'multi-google-analytics'),
      __('Google Analytics', 'multi-google-analytics'),
      'manage_options',
      self::OPTIONS_PAGE_SLUG,
      array($this, 'render_options_page')
    );
  }

  public function render_options_page() {
    include_once 'admin/options.php';
  }

  private function get_posted_property_ids() {
    $i = 1;
    $property_strings = array();
    while ( isset($_POST[self::OPTION_IDS . '-' . $i]) ) {
      $value = $_POST[self::OPTION_IDS . '-' . $i];
      if ( !empty( $value ) ) {
        $property_strings[] = sanitize_text_field( $value );
      }
      $i++;
    }
    return $property_strings;
  }

  public function validate_ua_string($ga_string) {
    $properties = $this->get_posted_property_ids();
    if ( !empty($properties) ){
      foreach ($properties as $property_id) {
        if (!preg_match( '/^UA-[0-9]{5,}-[0-9]{1}$/', $property_id ) ) {
          add_settings_error(self::OPTION_IDS, esc_attr('settings_updated'), __('Invalid format for property id. Format should be <code>UA-00000000-0</code>', 'multi-google-analytics'), 'error');
        }
        break;
      }
    }

    return $properties;
  }

  private function get_js_config() {
    return array(
      'name'    => self::PLUGIN_NAME,
      'options' => array(
        'ids' => array(
          'name'           => self::OPTION_IDS,
          'title' => __( "Property ID", "ahr" ),
          'btnAdd'        => __( "Add new property", "ahr" ),
          'btnDelete'     => __( "Delete property", "ahr" ),
          'container'      => sprintf("#%s-container", self::OPTION_IDS),
          'rowPlaceholder'      => 'UA-00000000-0',
          'rows' => get_option( self::OPTION_IDS ),
        ),
        'location' => array(
          'name'              => self::OPTION_LOCATION,
          'hook_name'         => self::PLUGIN_NAME,
          'default_hook_info' => __( "Determines which WordPress action is used to print the Google Analytics script. <code>wp_head</code> outputs the Google Analytics script in the &lt;head&gt; section. <code>wp_footer</code> outputs the script just before the closing &lt;/body&gt; tag.", "ahr" ),
          'custom_hook_info'  => sprintf( __("This is a custom hook you can use to print the analytics script if, for some reason, your theme doesn't call wp_head() or wp_footer(). To print the Google Analytics script manually, add the following line somewhere in your theme code. Preferably within the &lt;body&gt; element.<br><br><code>do_action( '%s' );</code>", "ahr"), self::PLUGIN_NAME )
        )
      )
    );
  }

  public function load_assets() {
    wp_register_script( 'ahr_ga/location-select', plugin_dir_url( __FILE__ ) . 'assets/location-select.js', array('jquery')  );
    wp_register_script( 'ahr_ga/property-id-repeater', plugin_dir_url( __FILE__ ) . 'assets/property-id-repeater.js', array('underscore', 'jquery', 'backbone')  );

    wp_localize_script( 'ahr_ga/property-id-repeater-select', 'ahr_ga_conf', $this->get_js_config() );
    wp_localize_script( 'ahr_ga/location-select', 'ahr_ga_conf', $this->get_js_config() );

    $screen = get_current_screen();
    if ( ('settings_page_' . self::OPTIONS_PAGE_SLUG) === $screen->base ) {
      wp_enqueue_script( 'ahr_ga/location-select' );
      wp_enqueue_script( 'ahr_ga/property-id-repeater' );
    }
  }

  public function add_analytics_script() {
    if ( empty( get_option( self::OPTION_IDS ) ) ) {
      return;
    }

    $script_file_path = plugin_dir_path(__FILE__) . 'frontend/ga-script.php';
    $script = apply_filters( self::PLUGIN_NAME . '/script_file_path', $script_file_path );

    include_once $script_file_path;
  }
}

new AhrGoogleAnalytics();