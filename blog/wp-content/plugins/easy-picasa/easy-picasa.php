<?php
/*
Plugin Name: Easy Picasa
Plugin URI: http://e-xia.com/plugins/easy-picasa/
Description: An simple but useful insert picasa plugin, can insert flash album, picture, multiple pictures. Extra light, based on jQuery only.
Version: 1.1
Author: YiXia
Author URI: http://e-xia.com/
*/

define("BACKGROUND", "ffffff");
define("PLUGINURI", WP_CONTENT_URL.'/plugins/'.dirname(plugin_basename(__FILE__)) );

add_shortcode('picasa','picasaflashslide_handler');
function picasaflashslide_handler($atts,$url){
//[picasa width="400" height="400" background="ffffff" autoplay="1" showcaption="1"]http://picasaweb.google.com/abttong/KTnkC02[/picasa]
    $defaults = array(
        'width' => '400',
        'height' => '400',
        'autoplay' => '0',
        'showcaption'=> '1',
        'background' => BACKGROUND
    );
    extract(shortcode_atts($defaults, $atts));
    if (empty($url)) return '';
    else{
      preg_match("@(?:http://)?picasaweb.google.com/([\w\.-]+)/([\w-\.%]+)#?\n?@i",$url, $matches);
      if($matches && count($matches) == 3){
        $user = $matches[1];
        $album = $matches[2];
      }else return '';
    }
    $noautoplay = (intval($autoplay) == 1)?'':'&amp;noautoplay=1';
    $caption = (intval($showcaption))?'&amp;captions=1':'';
    ob_start();
    ?>
<div class="center">
<object type="application/x-shockwave-flash" data="http://picasaweb.google.com/s/c/bin/slideshow.swf" width="<?php echo $width;?>" height="<?php echo $height;?>">
<param name="movie" value="http://picasaweb.google.com/s/c/bin/slideshow.swf" />
<param name="flashvars" value="host=picasaweb.google.com<?php echo $noautoplay; echo $caption;?>&amp;RGB=0x<?php echo $background;?>&amp;feed=http%3A%2F%2Fpicasaweb.google.com%2Fdata%2Ffeed%2Fapi%2Fuser%2F<?php echo $user;?>%2Falbum%2F<?php echo $album;?>%3Fkind%3Dphoto%26alt%3Drss" />
<param name="pluginspage" value="http://www.macromedia.com/go/getflashplayer" />
<param name="wmode" value="transparent" />
</object>
</div>
    <?php
    $slideshowcode = ob_get_contents();
    ob_end_clean();
    return $slideshowcode;
}

add_action('media_buttons','picasaflashslide_add_mediabutton',20);
function picasaflashslide_add_mediabutton(){
    $imgsrc = PLUGINURI . '/picasaicon.gif';
    $href = PLUGINURI . '/picasa.html?&amp;TB_iframe=true&amp;height=500&amp;width=750';
    $buttontips = __('Insert Picasa Photo(s)');
    echo "<a class='thickbox' title='Add Picasa Image' id='easypicasa' href='$href'><img src='$imgsrc' alt='$buttontips' tip='$buttontips' /></a>";
}
