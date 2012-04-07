=== Plugin Name ===
Contributors: YiXia
Tags: picasa,gallery,album,images,photos
Requires at least: 2.5
Tested up to: 2.7
Stable tag: trunk

A picasa plugin, insert flash album, single/multiple picture(s) by clicks. 谷歌相册插件，快速插入相册动画，单张或多张照片。

== Description ==

This is a very simple but useful plugin, it can help with insert XHTML validated flash album, or pictures, or multiple pictures by single click.

The picasa.js is a Picasa jQuery plugin, picasa.html can be run on local machine as a demo.

A [live demo](http://e-xia.com/blog/wp-content/plugins/easy-picasa/picasa.html "Easy Picasa") can also be found [HERE](http://e-xia.com/blog/wp-content/plugins/easy-picasa/picasa.html "Easy Picasa"). (Enter your Picasa username or 'tester' in the input box then click 'go'.)

现在已经有很多Picasa插件了，但不是调用了lightbox就是动用flash，块头一个比一个大，又没有完全实现我要的最简单的功能，本着自己动手丰衣足食的态度自己写个插件。用jquery实现picasa相册的调用，是一个静态的页面，大家可以直接拿出来玩（[在线演示](http://e-xia.com/blog/wp-content/plugins/easy-picasa/picasa.html "Easy Picasa")，请在输入框输入Picasa用户名或‘tester’，结果为弹出窗口）。可以插入最简单的图片，可以一次插入多张图片。如果直接插入相册则会转换成picasa的flash相册。整个插件没有向wp数据库里写入参数。用户名通过cookie保存。

== Installation ==

1. Upload `easy-picasa` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Albums list view
2. Pictures in single album
3. Icon in Editor and album flash in post