**** 概述****

cos-html-cache 将会大大地提高你wordpress的运行效率和载入速度。该插件会在页面第一次载入的时候产生和url对应的真正的html文件作为缓存，后面的运行将会直接载入该html从而大大的提高了页面的效率。当页面内容发生变化时将会自动更新对应的页面，更新缓存的触发事件有：修改文章、删除文章、评论成功提交，同时这些事件也将会更新与之相邻的文章。
cos-html-cache2.0和之前的版本相比大大的提高了速度，改进了缓存的机制，使之更加科学


**** 安装****

1. 下载插件，解压缩，你将会看到一个文件夹cos-html-cache，请确认文件夹里面没有二级目录，然后将其放置到插件目录下，插件目录通常是 `wp-content/plugins/`；
2. 在后台对应的插件管理页激活该插件；
3 在网站的根目录下创建一个文件 "index.bak"，并将属性设置成0666	
4 安装完成；

**** 卸载插件 ****

   1. 进入后台 admin->设置->cos-html-cache；
   2. 点击按钮删除所有的html缓存文件（请一定要删除）；
   3. 删除首页根目录下的index.html(如果存在)；
   4. 进入插件管理界面，禁用该插件；
   5. 卸载完成，若还有相关的html文件，请手动删除之。

**** FAQ ****

   1. 我后缀名是.htm不是.html的可以用么？
      后缀名是html或者html均可，其他方式不可以
   2. 如果我的永久连接是目录形式的可以用么？
      不可以，插件将会在目录下生成index.html文件。
   3. 缓存的静态HTML文件在哪里？
      放在你URL链接对应的地方，比如你页面的地址是http://www.xxx.com/dir1/dir2/2.html 那么静态文件就在 dir1/dir2 目录下
   4. 为什么后台没有批量更新了？
       请看最前面的说明，2.0的机制发生变化，已经不需要这个功能了！
   5. 如果我的永久连接不合理怎么办？    放心修改就是，不用担心链接失效问题，我自己都修改过几次，看看这里：http://www.storyday.com/html/y2007/706_permalinks-migration-plugin.html
   6. 静态化后不支持pingback，如何处理？
      在你的模板文件夹下的header.php文件中，加上这样的pingback meta：<link rel=”pingback” href=”<?php bloginfo(’pingback_url’); ?>” />，加在css调用之前，当调用静态文件的时候，htaccess和这个meta会帮你处理ping back的！
   7. 如何确定静态化成功？
      FTP查看有没有html文件生成，或者看看当前页面的源代码的最后面是否有这样的代码：<!-- create at yyyy-mm-dd hh:mm:ss by cos-html-cache 2.0 -->
   8. 生成了index.html为什么访问的还是index.php
      服务器配置文件访问优先级的问题，本插件无能为力，请修改服务器配置,如果你的服务器支持自定义htaccess,请在htaccess中增加DirectoryIndex index.html index.htm index.php index.cgi。
   9. 无法生成cache,如何处理?
      页无法生成是因为你的网站根目录不让写入文件，你可以自行建立index.html,设置属性为666，然后在后台任意更新一篇文章即可。其他页面无法生成，请检查对应文件夹的属性是不是777可写可读可执行，对于某些主机（如goddady）可能服务器系统系统参数配置不准确，你需要手动改动cos-htm-cache.php文件，修改方法参见：http://www.storyday.com/html/y2009/2245_about-cos-html-cache-and-godaddy-host-problem.html
   10.为什么我浏览页面之后并没有缓存文件生成？
       因为你处于登录状态，未登录用户访问的时候才会生成缓存
更多的帮助，请参考这个链接http://www.storyday.com/html/y2007/1213_cos-html-cache-2.html


永久链接更改的问题请访问这里：http://www.storyday.com/html/y2007/706_permalinks-migration-plugin.html