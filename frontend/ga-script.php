<?php
  $property_ids = apply_filters(
    AhrGoogleAnalytics::PLUGIN_NAME . '/property_ids',
    get_option( AhrGoogleAnalytics::OPTION_IDS )
  );
?>

<?php if ( !empty($property_ids) ) : ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  <?php
    for ( $i = 0; $i < count($property_ids); $i++ ) {
      $id = $property_ids[$i];
      printf( "\n  ga('create', '%s', 'auto', 'tracker_%s');", $id, $i );
      printf( "\n  ga('tracker_%s.send', 'pageview');", $i );
      echo "\n";
    }
  ?>
</script>
<?php endif; ?>