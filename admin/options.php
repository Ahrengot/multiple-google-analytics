<?php
  $ids = get_option( AhrGoogleAnalytics::OPTION_IDS );
  $location = get_option( AhrGoogleAnalytics::OPTION_LOCATION );
?>

<div class="wrap">
  <h1><?php _e('Google Analytics', 'ahr'); ?></h1>
  <form method="post" action="options.php">
    <?php settings_fields( AhrGoogleAnalytics::PLUGIN_NAME ); ?>
    <?php do_settings_sections( AhrGoogleAnalytics::PLUGIN_NAME ); ?>

    <div>
      <h2 class="title"><?php _e("Property ID's", "ahr"); ?></h2>
      <div id="<?php echo AhrGoogleAnalytics::OPTION_IDS; ?>-container"></div>
      <?php // this hidden field is required for our save hook to fire because the fields in our repeater have slightly modified names ?>
      <input type="hidden" name="<?php echo AhrGoogleAnalytics::OPTION_IDS; ?>">
    </div>

    <div>
      <h2 class="title"><?php _e("Script rendering", "ahr"); ?></h2>
      <table id="<?php echo AhrGoogleAnalytics::PLUGIN_NAME . AhrGoogleAnalytics::OPTION_LOCATION; ?>" class="form-table">
        <tr valign="top">
          <th scope="row"><?php _e('WordPress action', 'ahr'); ?></th>
          <td>
            <select name="<?php echo AhrGoogleAnalytics::OPTION_LOCATION; ?>">
              <?php $options = array('wp_head', 'wp_footer', AhrGoogleAnalytics::PLUGIN_NAME); foreach ($options as $option) : ?>
              <option value="<?php echo $option; ?>" <?php selected($location, $option) ?>><?php echo $option ?></option>
              <?php endforeach; ?>
            </select>
            <p class="description" id="<?php echo AhrGoogleAnalytics::OPTION_LOCATION; ?>-message" style="margin-bottom: 2rem;"></p>
          </td>
        </tr>
      </table>
    </div>

    <?php submit_button(); ?>
  </form>
</div>