****** cos-html-cache ******

Tags: html, cache,performance
Contributors: Jiangdong

cos-html-cache is an extremely efficient WordPress page caching plugin designed to make your WordPress site much faster and more responsive. Based on URL rewriting, the plugin will automatically generate real html files for posts when they are loaded for the first time, and automatically renew the html files if their associated posts are modified.
cos-html-cache. Current version, cos-html-cache2.6, is a huge improvement over previous versions of cos-html-cache.



**** Installation ****

1.Upload to your plugins folder, usually `wp-content/plugins/` and unzip the file, it will create a `wp-content/plugins/cos-html-cache/` directory.

2.Activate the plugin on the plugin screen.

3.Make that your perm link looks like a real html file : http://storyday.com/post/xxx.html
4.create a file named "index.bak" under the root of your web directory


3.done
**** Uninstallation ****

1.go into admin->options->cos-html-cache
2.delete all cache files (very important)
3.go into admin->plugins ,disable cos-html-cache
4.done.

**** Frequently Asked Questions ****

** Do I really need to use this plugin? **

* If your site gets Slashdotted
* If you're on a very slow server
* If you've had a complaint from your host about performance
* If you just want to blog rather than testing new plugins and functions of wordpress

** How can I tell if it's working? **

cos-html-cache adds some stats to the very end of a page in the HTML, so you can view source to see if there any codes like "<!-- create at yyyy-mm-dd hh:mm:ss by cos-html-cache 2.0 -->"

** Do you cache other pages such as cat ? **

No,this plugin only cache posts and pages.

**** More Info ****

For more info, please visit http://www.storyday.com/cos-html-cache

