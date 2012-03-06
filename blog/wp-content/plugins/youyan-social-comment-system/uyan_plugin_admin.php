<script language="javascript" src="../wp-content/plugins/youyan-social-comment-system/js/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../wp-content/plugins/youyan-social-comment-system/js/uyan_plugin.js"></script>
<script language="javascript" src="../wp-content/plugins/youyan-social-comment-system/js/youyan_admin_view.js"></script>
<script language="javascript" src="../wp-content/plugins/youyan-social-comment-system/js/easyXDM.min.js"></script>

<div class="contentWrapper"></div>

<script type="text/javascript">
$("#menu-comments a[href='edit-comments.php?page=uyan_import']").parent().hide();
$("#menu-comments a[href='edit-comments.php?page=uyan_export']").parent().hide();
$("#menu-comments a[href='edit-comments.php?page=uyan_bind']").parent().hide();
</script>

<link href="../wp-content/plugins/youyan-social-comment-system/css/global.css" rel="stylesheet" type="text/css" />
<link href="../wp-content/plugins/youyan-social-comment-system/css/boxy.css" rel="stylesheet" type="text/css" />
<link href="../wp-content/plugins/youyan-social-comment-system/css/login.css" rel="stylesheet" type="text/css" />

       <div class="innerContainer">
           <div class="contentTitle"><a class="unselectedTab currentTab" id="loginUyan" onclick="$('#loginUyan').addClass('currentTab');$('#signupUyan').removeClass('currentTab');$('#loginpart').css({'display':'block'});$('#signuppart').css({'display':'none'});">登录友言</a><a class="unselectedTab" onclick="$('#signupUyan').addClass('currentTab');$('#loginUyan').removeClass('currentTab');$('#loginpart').css({'display':'none'});$('#signuppart').css({'display':'block'});" id="signupUyan">注册</a><div class="clear"></div></div>
           <div id="loginpart">
                <div class="detailTitle">Email</div>
                <div class="inputURLWrapper inputURLWS">
                <input type="text" id="email" name="email" />
                <div class="clear"></div></div>
                <div class="detailTitle">密码</div>
                <div class="inputURLWrapper inputURLWS">
                <input type="password" id="password" name="password" />  
                <div class="clear"></div></div>
                <div class="submitWrapper">
                    <span id="alertLogin"></span><a class="loginBTNPane" onclick="submitLogin()">登录</a>
                    <div class="clear"></div>
                </div>        
                <div class="clear"></div>  
           </div>
           <div id="signuppart">
        <div class="inputUpTag">用户名</div>
        <div class="inputURLWrapper inputURLWS"><input type="text" id="inputUserName" name="inputUserName" class="inputURLS" onblur="checkUserName()"  /><div class="clear"></div></div>
        <div class="inputUpTag">Email</div>
        <div class="inputURLWrapper inputURLWS"><input type="text" id="inputEmail" name="inputEmail" class="inputURLS" onblur="checkEmail()"  /><div class="clear"></div></div>     
        <div class="inputUpTag">密码<span class="psAlert">(6位以上)</span></div>
        <div class="inputURLWrapper inputURLWS"><input type="password" id="inputPassword" name="inputPassword" class="inputURLS" onblur="checkPassword()"/><div class="clear"></div></div>       
        <script language="javascript">$("#inputUserName").val("");$("#inputEmail").val("");</script>
        <a id='signupBTNPane' onClick="submitSignup()">确定</a><div class="clear"></div>
                </div>

           <div class="introWhat">友言，为您的博客量身打造社交评论系统。</div>
           <div class="introWhy">(您也可以到http://uyan.cc注册与管理数据)</div>
                <div class="clear"></div>  
           </div>
       </div>        


<script language="javascript">
<?php if($_COOKIE['UYEmail']!=''&&$_COOKIE['UYPassword']!=''){?>
  UYAutoLogin('<?php echo $_COOKIE['UYEmail'];?>','<?php echo $_COOKIE['UYPassword'];?>');
<?php }?>	
</script>
