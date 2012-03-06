<?php
/*
* 
*/
function rs_connect($ftp_host="",$ftp_user="", $ftp_pass="",$ftp_port=22){
 
	global $rs_isconnectet,$sftp;
	if($rs_isconnectet!==true){
		include('sftp/SFTP.php');
		$sftp = new Net_SFTP($ftp_host,$ftp_port);
		if (!$sftp->login($ftp_user, $ftp_pass)) {
			exit('Login Failed');
		}
		$rs_isconnectet=true;
	 }
	 return $sftp;
}
function rs_disconnect(){

}
function rs_writefile($ziel, $quelle){

	$sftp=rs_connect();
	$handle = fopen ($quelle, "r");
	while (!feof($handle)) {
		$content .= fgets($handle, 4096);
	}	
	fclose ($handle);
	if($sftp->put($ziel, $content)===false){
	$dir=rs_recursivemkdir($ziel);
	if($sftp->put($ziel, $content)===false){
		echo "Have not enoth rigths to create Folders. tryed ($dir): ".$ziel;
		exit;
	}
	}
	 
}

function rs_readfile($datei){
$sftp=rs_connect();
$tmp="temp".time()."asde.tmp";
return $sftp->get($datei);
 
}

function rs_deletefile($file){
	$sftp=rs_connect();
	$sftp->delete($file);
}
function rs_writecontent($ziel,$content){
	$sftp=rs_connect();
	 $ziel=str_replace("//","/",$ziel);
	 
		if($sftp->put($ziel, $content)===false){
	 
	$dir=rs_recursivemkdir($ziel);
	 
	if($sftp->put($ziel, $content)===false){
		echo "Have not enoth rigths to create Folders. tryed ($dir): ".$ziel;
		exit;
	}
	}
 
	
	
}
 function rs_recursivemkdir($ziel){
	 global $sftp;
	$dir=split("/", $ziel);
	##
	unset($dir[count($dir)-1]);
	$dir=implode("/",$dir);
	$ddir=$dir;
	do{
		do{
		#echo "$dir<hr>";
			$fh =@$sftp->mkdir($dir);
			$okdir=$dir;
			$dir=split("/",$dir);
			unset($dir[count($dir)-1]);
			$dir=implode("/",$dir);

	 }while($dir!="" and $fh===false);
	 if($fh===false)die(str_replace("%folder%","$ziel",__("Im no able to create the directory %folder%! Please check writings rights!", 'reallystatic')));
	 $dir=$ddir;
	}while($okdir!=$dir);
	##
	return $dir;

}
/**
* text= errortex
* type 1=just debug 2=error-> halt
*/
function rs_error($text,$type){


}
?>