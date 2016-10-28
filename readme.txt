=== Easy Google Analytics ===
Contributors: Jens Ahrengot Boddum
Tags: Google Analytics
Requires at least: 4.0
Tested up to: 4.6.1
Stable tag: 1.0.0

Enables google analytics on all pages.

== Description ==

Minimalistic [Google Analytics](http://www.google.com/analytics/) plugin that lets you add one or more trackers and control exactly how the script is rendered.

= Rendering the script =
This plugin let's you control wether the Google Analytics script is printed in the <head>-element, the <body>-element or using a custom action.

There's also a filter available if you want to completely override the code that prints the analytics code. This way you can use the plugin simply for storing the property ID's in the database and have the analytics scripts exactly as your want it. 

That filter is `ahr-google-analtyics/script_file_path` and you use it like so: 

```add_filter('ahr-google-analtyics/script_file_path', function($default_path){
    // return an absolute file path to the file you want to use for rendering the script
}, 10, 1);
```

= Accessing the property ids via code =
If you need to manipulate the Google Analytics property ids before they are printed, then hook into the `ahr-google-analtyics'/property_ids` filter.

If you need to pull the ids from the database in any other context you can use `$property_ids = get_option( AhrGoogleAnalytics::OPTION_IDS );`

== Installation ==

1. Upload `ahr-google-analytics` directory to the `/wp-content/plugins/` directory OR search for 'Easy Google Analytics'
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add one or more web property IDs (UA-XXXXXXX-X strings) on the settings page

== Screenshots ==

1. Default settings with 1 tracker and the script printed in wp_footer()
2. Using multiple trackers and the custom hook for printing the script

== Changelog ==

= 1.0.0 =
* Initial release. Yay!
