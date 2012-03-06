<?php

#ison(!@touch(REALLYSTATICHOME."static/")),1,"red","green")
global $ison;
$ison=0;
if($_POST["pos"]==""){
	echo "<h1>".__("Really-Static Quickstart", 'reallystatic')."</h1>";
	echo __("Thank you for choosing Really-Static! At the moment Really-Static is set to save the generated files into a temporary folder. This ensures that you can test the plugin, without destroying anything.", 'reallystatic');
	echo "<br><h2>".__("STEP 1: Testing Accessrights", 'reallystatic')."</h2>";
	echo '<table width="200"><tr><td style="background-color:'.ison(@touch(LOGFILE),1,"green","red").';">'.__('Logfile','reallystatic').'</td> </tr></table>';
	echo '<table width="200"><tr><td style="background-color:'.ison(@touch(REALLYSTATICHOME."static/test.txt"),1,"green","red").';">'.__('Static-Folder','reallystatic').'</td> </tr></table>';

	if($ison==2)echo '<form method="post"><input type="hidden" name="pos" value="1" /><input name="Submit1" type="submit" value="'.__('Next >>', 'reallystatic').'" /></form>';
	else echo '<form method="post"><input type="hidden" name="pos" value="" /><input name="Submit1" type="submit" value="'.__('Refresh', 'reallystatic').'"/></form>';
}elseif($_POST["pos"]=="1"){
	echo "<h2>".__("STEP 2: Trying Create, Read and Delete a File", 'reallystatic')."</h2>";
	$da=time()."test.txt";
	$te="TESTESTSETSE".time();
	require_once ("local.php");
	rs_connect();
	rs_writecontent(loaddaten( "realstaticlokalerspeicherpfad" ).  $da, $te);
	echo '<table width="200"><tr><td style="background-color:'.ison(really_static_download(loaddaten ( "realstaticremoteurl", 'reallystatic' ).$da)==$te,1,"green","red").';">'.__("Trying Write/Read/Delete File", 'reallystatic').'</td> </tr></table>';
	rs_deletefile(loaddaten( "realstaticlokalerspeicherpfad" ) .  $da);


	if($ison==1)echo '<form method="post"><input type="hidden" name="pos" value="2" /><input name="Submit1" type="submit" value="'.__('Next >>', 'reallystatic').'" /></form>';
	else echo '<form method="post"><input type="hidden" name="pos" value="1" /><input name="Submit1" type="submit" value="'.__('Refresh', 'reallystatic').'" /></form>';

}elseif($_POST["pos"]=="2"){
	echo "<h2>".__("STEP 3: Generating your current Blog into a tempoary folder", 'reallystatic')."</h2>";
	echo '<form  method="post" id="my_fieldset"><input type="hidden" name="strid2" value="rs_refresh" />
	<input type="hidden" name="hideme" value="hidden" />
	<input type="hidden" name="pos" value="3" />
	<input type="submit" value="'.__("Generate staticfiles out of my Blog into a tempoary folder", 'reallystatic').'"></form><a target="_blank" href="options-general.php?page='.$base.'">'.__('or goto the Settingspage', 'reallystatic').'</a>';
}elseif($_POST["pos"]=="3"){
 

$lastposts = get_posts ( 'numberposts=1 ' );
foreach ( $lastposts as $post ) {
	$r=get_permalink ( $post->ID );
	$r=loaddaten( "realstaticremoteurl" ).str_replace(get_option('home')."/","",nonpermanent($r));
}
 
echo "<hr>";
echo "<br><b>";
echo __("OK, Ready!", 'reallystatic');
echo "</b><br>";
echo sprintf(__("You static files are locatet here: <a target='_blank' href='%s'>%s</a>", 'reallystatic'), loaddaten( "remoteurl" ), loaddaten( "remoteurl" ));
echo "<br>";
echo "<br>";
echo __("On your server the files are locatet: ", 'reallystatic'). loaddaten( "realstaticlokalerspeicherpfad" );
echo "<br>";
echo "<br>";
echo sprintf(__("An example: <a target='_blank' href='%s'>%s</a>", 'reallystatic'),$r,$r);
echo "<br><br>Have fun and please dont forget to donate!";

 

}else die("eroro");
?>