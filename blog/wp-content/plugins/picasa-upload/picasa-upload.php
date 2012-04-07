<?php
/*
Plugin Name: Google+/Picasa Upload
Plugin URI: http://wordpress.org/extend/plugins/picasa-upload/
Description: integrierter Upload zu Picasa Web beim verfassen von Artikel
Version: 0.7.1
Author: Pascal
Author URI: http://www.pascal90.de
Plugin URI: http://www.pascal90.de/2011/09/picasa-upload-wordpress-plugin/
*/

//laedt picasa in wordpress
function picasa_upload_scripts() {?> 
<script src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
	//picker erstellen
	google.setOnLoadCallback(createPicker);
	//picker laden
	google.load('picker', '1');

	//Picker Upload+Auswahl aus Alben
	function createPicker() {
		var picker = new google.picker.PickerBuilder().
			addView(google.picker.ViewId.PHOTO_UPLOAD).
			addView(google.picker.ViewId.PHOTOS).
			setSize(650,500).
			setTitle("Bild hochladen/ausw\u00e4hlen").
			setCallback(pickerCallback).
			build();
		picker.setVisible(true);
	}

	//Google Picker Daten einfuegen
	function pickerCallback(data) {
		//Image URL, Link URL, Dateiname holen
		var pw_imageurl = ((data.action == google.picker.Action.PICKED) ? data.docs[0].thumbnails[3].url : '');
		var pw_linkurl = ((data.action == google.picker.Action.PICKED) ? data.docs[0].thumbnails[4].url : '');
		var pw_name = ((data.action == google.picker.Action.PICKED) ? data.docs[0].name : '');
		//aktuellen Fehler in der API ersetzen
		var pw_fullurl=pw_linkurl.replace(pw_name,"s2048/"+pw_name);
		
		//in Felder einfuegen
		document.getElementById('src').value=pw_imageurl;
		document.getElementById('url').value=pw_fullurl;
		addExtImage.getImageData();//wp funktion für gueltiges Bild ausfuehren. 
		
    }
    </script>
<?php  
} 
//script hinzufügen, wenn Bild und von url
if(!empty($_GET['tab'])&&$_GET['tab']=='type_url')
{
	add_action( 'admin_print_scripts-media-upload-popup','picasa_upload_scripts' ); 
}
?>