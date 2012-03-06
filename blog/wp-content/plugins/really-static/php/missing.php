<?php

		$h="";
		
		
 
 
		if($name=="dateierweiterungen")add_option ( 'dateierweiterungen', array(
		'.jpg' =>1,
		'.png'=>1 ,
		'.jpeg'=>1 ,
		'.gif'=>1 ,
		'.swf'=>1 ,
		'.gz'=>1,
		'.tar'=>1 ,
		'.pdf'=>1 ,
		), '', 'yes' );
		
		
		
		if($name=="rs_counter")add_option ( $name,0, '', 'yes' );
		if($name=="rs_firstTime")add_option ( 'rs_firstTime', -1, '', 'yes' );
		if($name=="makestatic-a1")add_option ( 'makestatic-a1', array(array("%indexurl%","")), '', 'yes' );
		if($name=="makestatic-a2")add_option ( 'makestatic-a2', array(array("%tagurl%","")), '', 'yes' );
		if($name=="makestatic-a3")add_option ( 'makestatic-a3', array(array("%caturl%","")), '', 'yes' );
		if($name=="makestatic-a4")add_option ( 'makestatic-a4', array(array("%authorurl%","")), '', 'yes' );
		if($name=="makestatic-a5")add_option ( 'makestatic-a5', array(array("%dateurl%","")), '', 'yes' );
		if($name=="realstaticposteditcreatedelete")add_option('realstaticposteditcreatedelete',array(array("%postname%","")),'','');
		
		if($name=="realstaticurlrewriteinto")add_option ( 'realstaticurlrewriteinto', array(), '', 'yes' );
		
		//Doofihilfe
		if($name=="realstaticlokalerspeicherpfad")add_option ( 'realstaticlokalerspeicherpfad', REALLYSTATICHOME.'static/', '', 'yes' );
		if($name=="realstaticspeicherart")add_option ( 'realstaticspeicherart', '2', '', 'yes' );
		if($name=="realstaticnonpermanent"){
		if(get_option('permalink_structure')=="")add_option('realstaticnonpermanent',1,'','');
		else add_option('realstaticnonpermanent',0,'','');
		}		
				
		
		if($name=="realstaticlocalpath")add_option ( 'realstaticlocalpath', '', '', 'yes' );
		if($name=="realstaticsubpfad")add_option ( 'realstaticsubpfad', '', '', 'yes' );
		if($name=="realstaticremoteurl")add_option ( 'realstaticremoteurl', REALLYSTATICURLHOME."static/", '', 'yes' );

		if($name=="realstaticlocalurl")add_option ( 'realstaticlocalurl', get_option('home')."/", '', 'yes' );
		
		if($name=="realstaticremotepath")add_option ( 'realstaticremotepath', "/", '', 'yes' );
		if($name=="realstaticftpserver")add_option ( 'realstaticftpserver', "", '', 'yes' );
		if($name=="realstaticftpuser")add_option ( 'realstaticftpuser', "", '', 'yes' );
		if($name=="realstaticftppasswort")add_option ( 'realstaticftppasswort', "", '', 'yes' );
		if($name=="realstaticftpport")add_option ( 'realstaticftpport', "21", '', 'yes' );
		
		if($name=="realstaticremotepathsftp")add_option ( 'realstaticremotepathsftp', "/", '', 'yes' );
		if($name=="realstaticsftpserver")add_option ( 'realstaticsftpserver', "", '', 'yes' );
		if($name=="realstaticsftpuser")add_option ( 'realstaticsftpuser', "", '', 'yes' );
		if($name=="realstaticsftppasswort")add_option ( 'realstaticsftppasswort', "", '', 'yes' );
		if($name=="realstaticsftpport")add_option ( 'realstaticsftpport', "22", '', 'yes' );	
		
		
		if($name=="realstaticdesignlocal")add_option ( 'realstaticdesignlocal', get_bloginfo('template_directory')."/", '', 'yes' );
		if($name=="realstaticdesignremote")add_option ( 'realstaticdesignremote', get_bloginfo('template_directory')."/", '', 'yes' );
		if($name=="realstaticeverytime")add_option('realstaticeverytime',array(),'','');
		if($name=="realstaticpageeditcreatedelete")add_option('realstaticpageeditcreatedelete',array(),'','');
		if($name=="realstaticcommenteditcreatedelete")add_option('realstaticcommenteditcreatedelete',array(),'','');
		if($name=="realstaticeveryday")add_option('realstaticeveryday',array(),'','');

		if($name=="realstaticdonationid")add_option('realstaticdonationid',"",'','');

		if($name=="maketagstatic")add_option('maketagstatic',1,'','');
		if($name=="makecatstatic")add_option('makecatstatic',1,'','');
		if($name=="makeauthorstatic")add_option('makeauthorstatic',1,'','');
		if($name=="makedatestatic")add_option('makedatestatic',1,'','');
		if($name=="makeindexstatic")add_option('makeindexstatic',1,'','');
		

?>