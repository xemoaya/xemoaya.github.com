<?php
ob_start("ob_gzhandler");
ob_start("compress");
header("Content-type: text/javascript;charset: UTF-8");
header("Cache-Control: must-revalidate");

function compress($buffer) {
    return $buffer;
}
$logged_cookie_key = "wordpress_logged_in_".htmlspecialchars($_GET['hash']);

?>
var admin_user_cookie = "<?php array_key_exists($logged_cookie_key, $_COOKIE)?$tmp=$_COOKIE[$logged_cookie_key]:$tmp="";echo $tmp;?>";
function readCosBetaCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return unescape( decodeURI(c.substring(nameEQ.length,c.length)));
	}
	return '';
}
function setovalue(o,v){
	if(document.getElementById(o)  !=null )document.getElementById(o).value=v.replace('+',' ');
}
function setCommForm(){
if (admin_user_cookie.length > 2) {
		setovalue('author',admin_user_cookie.split("|")[0]);
		setovalue('email',adminmail.replace("{_}","@") );
		setovalue('url',adminurl );
	}
else if(readCosBetaCookie(author_cookie).length>2){		
		setovalue('author',readCosBetaCookie(author_cookie) );
		setovalue('email',readCosBetaCookie(email_cookie) );
		setovalue('url',readCosBetaCookie(url_cookie) );
	}
	else{
		setovalue('author','');setovalue('email','');setovalue('url','');
	}
}