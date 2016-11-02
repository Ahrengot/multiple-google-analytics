# Multiple Google Analytics
![Plugin thumbnail](http://i.imgur.com/YLLCWFL.png)
Minimalistic [Google Analytics](http://www.google.com/analytics/) plugin that lets you add one or more trackers and control exactly how the script is rendered.

-----------------------

* WordPress repository: https://wordpress.org/plugins/multi-google-analytics/
* Readme : https://github.com/Ahrengot/multiple-google-analytics/blob/master/readme.txt

## Screenshots
![Default settings](http://i.imgur.com/OoF17nC.png)
**Default settings with 1 tracker and the script printed in `wp_footer()`**

![Using multiple trackers and custom action](http://i.imgur.com/FMWVbHp.png)
**Using multiple trackers and the custom hook for printing the script**

## What is printed?
Let's say you have 2 trackers `UA-00000000-1` and `UA-00000000-2`. Here's what the plugin will print on the page (via [/frontend/ga-script.php](https://github.com/Ahrengot/multiple-google-analytics/blob/master/frontend/ga-script.php)):

```JavaScript
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  
  ga('create', 'UA-00000000-1', 'auto', 'tracker_0');
  ga('tracker_0.send', 'pageview');

  ga('create', 'UA-00000000-2', 'auto', 'tracker_1');
  ga('tracker_1.send', 'pageview');
</script>
```

Naturally, the plugin works fine if you just have a single tracker.

Read more about dealing with multiple Google Analytics trackers here: https://developers.google.com/analytics/devguides/collection/analyticsjs/creating-trackers#working_with_multiple_trackers