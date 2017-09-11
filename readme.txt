=== Multiple Google Analytics Trackers ===
Contributors: Ahrengot
Tags: analytics, Google Analytics, google, statistics, stats, tracking
Requires at least: 4.0
Tested up to: 4.8.1
Stable tag: 1.1.2
License: GPL v3

Add one or more Google Analytics trackers to your website.

== Description ==

Minimalistic [Google Analytics](http://www.google.com/analytics/) plugin that lets you add one or more trackers and control exactly how the script is rendered.

= Rendering the script =
This plugin lets you control wether the Google Analytics script is printed in the `<head>`-element, the `<body>`-element or using a custom action.

There's also a filter available, if you want to completely override the code that prints the analytics code. This way you can use the plugin simply for storing the property ID's in the database and manually render the analytics script exactly as your want it. 

The filter for overriding the script code is `ahr-google-analtyics/script_file_path` and you'd use it like so: 

    add_filter('ahr-google-analtyics/script_file_path', function($default_path){
        // return an absolute file path to the file you want to use for rendering the script
    }, 10, 1);

= Accessing the property ids via code =
If you need to manipulate the Google Analytics property ids before they are printed, then use the `ahr-google-analtyics'/property_ids` filter. It'll pass you an array of property ids as its single argument.

If you need to pull the ids from the database, in any other context, you can use `$property_ids = get_option( AhrGoogleAnalytics::OPTION_IDS );`

This plugin will always give you an array of ids. Even if you just have one.

= Source code & contributions =
Please feel free to contribute improvements, report bugs or suggest new features via the GitHub repo

* [Github Repo](https://github.com/Ahrengot/multiple-google-analytics)
* [Suggest improvements](https://github.com/Ahrengot/multiple-google-analytics/issues)
* [Open a pull request](https://github.com/Ahrengot/multiple-google-analytics/pulls)

== Frequently Asked Questions ==

= What is a Google Analytics property ID? =
It's the string looking like `UA-XXXXXXX-X` next to your website URL on https://analytics.google.com/analytics/web/


= JavaScript: How do I track pageviews/events/etc. using multiple trackers =
If you're building a JavaScript-based web app and manually need to track custom routes or events you can use the `ga.getAll()` method to get an array of registered trackers and then run the tracking logic for each tracker. 

For example, this will track page views based on custom routes:

    if ( typeof ga === 'function' && typeof ga.getAll === 'function' ) {
      ga.getAll().forEach(tracker => {
        tracker.set('page', *my-custom-route*); // Custom route e.g. '/my-page'
        tracker.send('pageview');
      })
    }
    
And here's an example of tracking custom events:

    if ( typeof ga === 'function' && typeof ga.getAll === 'function' ) {
      ga.getAll().forEach(tracker => {
        tracker.send('event', {
          eventCategory: 'Search',
          eventAction: 'Query',
          eventLabel: *query*, // Your search query
          eventValue: *matches.length* // Optionally, send the number of matches for the query
        });
      })
    }


== Upgrade Notice ==

= 1.1.2 =
Add support for the new longer google analytics ID’s

= 1.1.1 =
Fixes a bug where default values weren’t set properly when first activating plugin

= 1.0.1 =
Fixes typos in plugin activation/deactivation callback functions

= 1.0.0 =
Initial plugin release.

== Installation ==

1. Move the `ahr-google-analytics` folder to the `/wp-content/plugins/` directory OR search for ‘Multiple Google Analytics' and add the plugin using WordPress' plugin browser.
2. Activate the plugin through the 'Plugins' page in WordPress
3. Add one or more web property IDs (UA-XXXXXXX-X strings) on the settings page

== Screenshots ==

1. Default settings with 1 tracker and the script printed in wp_footer()
2. Using multiple trackers and the custom hook for printing the script

== Changelog ==

= 1.1.2 =
Release Date: September 11th, 2017

Add support for the new longer google analytics ID’s that would previously be rejected by the validator

= 1.1.1 =
Release Date: March 15th, 2017

Fixes a bug where default values weren’t set properly when first activating plugin

= 1.0.1 =
Release Date: December 11th, 2016

Fixes typos in plugin activation/deactivation callback functions

= 1.0.0 =

Release Date: November 2nd, 2016

* Initial release. Yay!
