<?php
/*
 *
 */
function rs_connect(){
	global $rs_isconnectet;
	$rs_isconnectet=true;
}
function rs_disconnect(){
	global $rs_isconnectet;
	$rs_isconnectet=false;
}
function rs_writefile($ziel, $quelle){
	$fh=@copy($quelle,$ziel);
	#echo "copy('$quelle','$ziel');";
	if($fh===false){
		$dir=rs_recursivemkdir($ziel);
	}
	$fh=@copy($quelle,$ziel);
	if($fh===false){
		echo "Have not enoth rigths to create Folders. tryed ($dir): ".$ziel;
		exit;
	}


}
function rs_deletefile($datei){
	unlink($datei);

}
function rs_writecontent($ziel,$content){
	$fh = @fopen( $ziel, 'w+') ;
	if($fh===false){$dir=rs_recursivemkdir($ziel);
	$fh = @fopen( $ziel, 'w+') ;
	if($fh===false){
		echo "Have not enoth rigths to create Folders. tryed ($dir): ".$ziel;
		exit;
	}
	}
	fwrite($fh, $content);
	fclose($fh);
}
function rs_recursivemkdir($ziel){
	$dir=split("/", $ziel);
	##
	unset($dir[count($dir)-1]);
	$dir=implode("/",$dir);
	$ddir=$dir;
	do{
		do{
		#echo "$dir<hr>";
			$fh =@mkdir($dir);
			$okdir=$dir;
			$dir=split("/",$dir);
			unset($dir[count($dir)-1]);
			$dir=implode("/",$dir);

	 }while($dir!="" and $fh===false);
	 if($fh===false)die(reallystatic_configerror(3,$ziel));
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