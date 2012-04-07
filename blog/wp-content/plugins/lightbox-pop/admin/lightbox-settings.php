<?php
	// Load the options

	if (isset($_POST['xyz_lbx_html']))
	{
		$xyz_lbx_html=stripslashes($_POST['xyz_lbx_html']);
		$xyz_lbx_top=abs(intval($_POST['xyz_lbx_top']));
		$xyz_lbx_width=abs(intval($_POST['xyz_lbx_width']));
		$xyz_lbx_height=abs(intval($_POST['xyz_lbx_height']));
		$xyz_lbx_left=abs(intval($_POST['xyz_lbx_left']));
		$xyz_lbx_delay=abs(intval($_POST['xyz_lbx_delay']));
		$xyz_lbx_page_count=abs(intval($_POST['xyz_lbx_page_count']));
		$xyz_lbx_repeat_interval=abs(intval($_POST['xyz_lbx_repeat_interval']));
		$xyz_lbx_mode=$_POST['xyz_lbx_mode'];
		$xyz_lbx_z_index=intval($_POST['xyz_lbx_z_index']);
		$xyz_lbx_opacity=abs(intval($_POST['xyz_lbx_opacity']));
		$xyz_lbx_color=$_POST['xyz_lbx_color'];
		 $xyz_lbx_bg_color=$_POST['xyz_lbx_bg_color'];		
		$xyz_lbx_corner_radius=abs(intval($_POST['xyz_lbx_corner_radius']));
		$xyz_lbx_top_dim=$_POST['xyz_lbx_top_dim'];
		$xyz_lbx_left_dim=$_POST['xyz_lbx_left_dim'];
		$xyz_lbx_width_dim=$_POST['xyz_lbx_width_dim'];
		$xyz_lbx_height_dim=$_POST['xyz_lbx_height_dim'];
		$xyz_lbx_border_color=$_POST['xyz_lbx_border_color'];
		$xyz_lbx_border_width=$_POST['xyz_lbx_border_width'];


$old_page_count=get_option('xyz_lbx_page_count');
$old_repeat_interval=get_option('xyz_lbx_repeat_interval');

		update_option('xyz_lbx_html',$xyz_lbx_html);
		update_option('xyz_lbx_top',$xyz_lbx_top);
		update_option('xyz_lbx_width',$xyz_lbx_width);
		update_option('xyz_lbx_height',$xyz_lbx_height);
		update_option('xyz_lbx_left',$xyz_lbx_left);
		update_option('xyz_lbx_delay',$xyz_lbx_delay);
		update_option('xyz_lbx_page_count',$xyz_lbx_page_count);
		update_option('xyz_lbx_repeat_interval',$xyz_lbx_repeat_interval);
		update_option('xyz_lbx_mode',$xyz_lbx_mode);
		update_option('xyz_lbx_z_index',$xyz_lbx_z_index);
		update_option('xyz_lbx_opacity',$xyz_lbx_opacity);
		update_option('xyz_lbx_color',$xyz_lbx_color);
		update_option('xyz_lbx_corner_radius',$xyz_lbx_corner_radius);
		update_option('xyz_lbx_top_dim',$xyz_lbx_top_dim);
		update_option('xyz_lbx_height_dim',$xyz_lbx_height_dim);	
		update_option('xyz_lbx_left_dim',$xyz_lbx_left_dim);
		update_option('xyz_lbx_width_dim',$xyz_lbx_width_dim);
		update_option('xyz_lbx_border_color',$xyz_lbx_border_color);
		update_option('xyz_lbx_bg_color',$xyz_lbx_bg_color);
		update_option('xyz_lbx_border_width',$xyz_lbx_border_width);
	
		?><br>
		
<div style="background-color:#00FF33;font-size:14px;font-weight:bold;width:800px;border-radius:4px; ">Settings updated successfully.</div>
<?php
}


?>
<style type="text/css">
label{
cursor:default;


}
</style>
<script type="text/javascript">
 
  jQuery(document).ready(function() {
    jQuery('#lbxcolorpicker').hide();
    jQuery('#lbxcolorpicker').farbtastic("#xyz_lbx_color");
    jQuery("#xyz_lbx_color").click(function(){jQuery('#lbxcolorpicker').slideToggle();});
    jQuery('#lbxbordercolorpicker').hide();
    jQuery('#lbxbordercolorpicker').farbtastic("#xyz_lbx_border_color");
    jQuery("#xyz_lbx_border_color").click(function(){jQuery('#lbxbordercolorpicker').slideToggle();});
    
    jQuery('#lbxbgcolorpicker').hide();
    jQuery('#lbxbgcolorpicker').farbtastic("#xyz_lbx_bg_color");
    jQuery("#xyz_lbx_bg_color").click(function(){jQuery('#lbxbgcolorpicker').slideToggle();});
    
  });
</script>
<div >
<h2>Lightbox Plugin Settings</h2>
<form method="post" >

<table  align="left" width="800px">
<tr valign="top" >
<td width="350" scope="row" ><h3>Lightbox  Content</h3></td>
<td width="450"></td>
</tr>
<tr valign="top" >
<td colspan="2" >

<?php the_editor(get_option('xyz_lbx_html'),'xyz_lbx_html');?></td>
</tr>
<?php  $xyz_lbx_top_dim=get_option('xyz_lbx_top_dim');
$xyz_lbx_left_dim=get_option('xyz_lbx_left_dim');
$xyz_lbx_height_dim=get_option('xyz_lbx_height_dim');
$xyz_lbx_width_dim=get_option('xyz_lbx_width_dim');

?>
<tr valign="top"><td scope="row"><h3>Lightbox Position Settings</h3></td></tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_top">Lightbox Top Coordinate</label></td>
<td><input name="xyz_lbx_top" type="text" id="xyz_lbx_top"  value="<?php print(get_option('xyz_lbx_top')); ?>" size="40" /><select  name="xyz_lbx_top_dim"   id="xyz_lbx_top_dim" >
<option value ="px" <?php if($xyz_lbx_top_dim=='px') echo 'selected'; ?>>px</option>
<option value ="%" <?php if($xyz_lbx_top_dim=='%') echo 'selected'; ?>>%</option>

</select></td>
</tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_left">Lightbox Left Coordinate</label></td>
<td><input name="xyz_lbx_left" type="text" id="xyz_lbx_left"  value="<?php print(get_option('xyz_lbx_left')); ?>" size="40" /><select  name="xyz_lbx_left_dim"   id="xyz_lbx_left_dim" >
<option value ="px" <?php if($xyz_lbx_left_dim=='px') echo 'selected'; ?>>px</option>
<option value ="%" <?php if($xyz_lbx_left_dim=='%') echo 'selected'; ?>>%</option>

</select></td>
</tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_width">Lightbox Width</label></td>
<td><input name="xyz_lbx_width" type="text" id="xyz_lbx_width"  value="<?php print(get_option('xyz_lbx_width')); ?>" size="40" /> <select  name="xyz_lbx_width_dim"   id="xyz_lbx_width_dim" >
<option value ="px" <?php if($xyz_lbx_width_dim=='px') echo 'selected'; ?>>px</option>
<option value ="%" <?php if($xyz_lbx_width_dim=='%') echo 'selected'; ?>>%</option>

</select>
</td>
</tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_height">Lightbox Height</label></td>
<td><input name="xyz_lbx_height" type="text" id="xyz_lbx_height"  value="<?php print(get_option('xyz_lbx_height')); ?>" size="40" /><select  name="xyz_lbx_height_dim"   id="xyz_lbx_height_dim" >
<option value ="px" <?php if($xyz_lbx_height_dim=='px') echo 'selected'; ?>>px</option>
<option value ="%" <?php if($xyz_lbx_height_dim=='%') echo 'selected'; ?>>%</option>

</select></td>
</tr>
<?php
$xyz_lbx_mode=get_option('xyz_lbx_mode');
?>
<tr valign="top"><td scope="row"><h3>Lightbox Display Logic Settings</h3></td></tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_mode">Lightbox display logic </label></td>
<td><select  name="xyz_lbx_mode"   id="xyz_lbx_mode" >
<option value ="delay_only" <?php if($xyz_lbx_mode=='delay_only') echo 'selected'; ?>>Based on delay </option>
<option value ="page_count_only" <?php if($xyz_lbx_mode=='page_count_only') echo 'selected'; ?>>Based on  number of pages browsed </option>
<option value ="both" <?php if($xyz_lbx_mode=='both') echo 'selected'; ?>>Based on both </option>
</select></td>
</tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_delay"> Delay in seconds before lightbox apppears </label></td>
<td><input name="xyz_lbx_delay" type="text" id="xyz_lbx_delay"  value="<?php print(get_option('xyz_lbx_delay')); ?>" size="40" /> sec</td>
</tr>

<tr valign="top">
<td scope="row"><label for="xyz_lbx_page_count">Number of pages to browse before lightbox appears</label></td>
<td><input name="xyz_lbx_page_count" type="text" id="xyz_lbx_page_count"  value="<?php print(get_option('xyz_lbx_page_count')); ?>" size="40" /> pages</td>
</tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_repeat_interval">Lightbox repeat interval for a user </label></td>
<td><input name="xyz_lbx_repeat_interval" type="text" id="xyz_lbx_repeat_interval"  value="<?php print(get_option('xyz_lbx_repeat_interval')); ?>" size="40" /> hrs</td>
</tr>
<tr valign="top"><td scope="row"><h3>Lightbox Style Settings</h3></td></tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_z_index">Lightbox z index</label></td>
<td><input name="xyz_lbx_z_index" type="text" id="xyz_lbx_z_index"  value="<?php print(get_option('xyz_lbx_z_index')); ?>" size="40" /> </td>
</tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_opacity">Lightbox overlay opacity(0-100)</label></td>
<td><input name="xyz_lbx_opacity" type="text" id="xyz_lbx_opacity" value="<?php print(get_option('xyz_lbx_opacity')); ?>" size="40" /> </td>
</tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_color">Lightbox overlay color</label></td>
<td><input name="xyz_lbx_color" type="text" id="xyz_lbx_color"  value="<?php print(get_option('xyz_lbx_color')); ?>" size="40" /> <div id="lbxcolorpicker"></div> </td>
</tr>

<tr valign="top">
<td scope="row"><label for="xyz_lbx_bg_color">Lightbox background color</label></td>
<td><input name="xyz_lbx_bg_color" type="text" id="xyz_lbx_bg_color"  value="<?php print(get_option('xyz_lbx_bg_color')); ?>" size="40" /> <div id="lbxbgcolorpicker"></div> </td>
</tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_border_color">Lightbox border color</label></td>
<td><input name="xyz_lbx_border_color" type="text" id="xyz_lbx_border_color"  value="<?php print(get_option('xyz_lbx_border_color')); ?>" size="40" /> <div id="lbxbordercolorpicker"></div> </td>
</tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_border_width">Lightbox  border  width </label></td>
<td><input name="xyz_lbx_border_width" type="text" id="xyz_lbx_border_width"  value="<?php print(get_option('xyz_lbx_border_width')); ?>" size="40" /> px </td>
</tr>
<tr valign="top">
<td scope="row"><label for="xyz_lbx_corner_radius">Lightbox  border  radius </label></td>
<td><input name="xyz_lbx_corner_radius" type="text" id="xyz_lbx_corner_radius"  value="<?php print(get_option('xyz_lbx_corner_radius')); ?>" size="40" /> px </td>
</tr>
<tr>
<td scope="row"> </td>
<td><br>
<input type="submit" value=" Update Settings " /></td>
</tr>

</table>


</form>

</div>

<script language="javascript">

 var cookie_date = new Date ( );  // current date & time
 cookie_date.setTime ( cookie_date.getTime() - 1 );

<?php
		if($old_page_count!=$xyz_lbx_page_count)
		{
?>
  document.cookie = "_xyz_lbx_pc=; expires=" + cookie_date.toGMTString()+ ";path=/";
<?php
		}
		if($old_repeat_interval!=$xyz_lbx_repeat_interval)
		{
?>
  document.cookie = "_xyz_lbx_until=; expires=" + cookie_date.toGMTString()+ ";path=/";
<?php
		}
		

?>


</script>
