<?php
/**
 * Widget - Flickr Badges Widget
 * 
 * @package zFrame
 * @subpackage Classes
 * For another improvement, you can drop email to zourbuth@gmail.com or visit http://zourbuth.com
**/
 
class Flickr_Badges_Widget extends WP_Widget {

	/** Set up the widget's unique name, ID, class, description, and other options. **/
	function __construct() {
		
		/* Set up the widget control options. */
		$control_options = array(
			'width' => 525,
			'height' => 350,
			'id_base' => "flickr-badges"
		);
		/** Add some informations to the widget **/
		$widget_options = array('classname' => 'flickr-badges', 'description' => __( 'Displays a Flickr photo stream from an ID', $this->textdomain ) );
		
		/* Create the widget. */
		$this->WP_Widget('flickr-badges', __('Flickr Badge', $this->textdomain), $widget_options, $control_options );
		
		/* Load the widget style only at the widget appereance page. */
		add_action( 'load-widgets.php', array( &$this, 'flickr_badges_admin' ) );
		
		if ( is_active_widget(false, false, $this->id_base, true) ) {
			/* load the widget stylesheet for the widgets screen. */
			wp_enqueue_style( 'flickr-badges', FLICKR_BADGES_WIDGET_URL . 'css/widget.css', false, 0.7, 'screen' );
			wp_enqueue_style( 'flickr-badges' );
		}
	}

	/** enqueue the widget option stylesheet css **/
	function flickr_badges_admin() {
		wp_enqueue_style( 'flickr-badges-admin', FLICKR_BADGES_WIDGET_URL . 'css/admin.css', false, 0.7, 'screen' );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title 			= apply_filters('widget_title', empty($instance['title']) ? __('Photos on flickr', $this->textdomain) : $instance['title'], $instance, $this->id_base);
		$type 			= empty( $instance['type'] ) ? 'user' : $instance['type'];
		$flickr_id 		= $instance['flickr_id'];
		$count 			= (int)$instance['count'];
		$intro_text 	= $instance['intro_text'];
		$outro_text 	= $instance['outro_text'];
		$display 		= empty( $instance['display'] ) ? 'latest' : $instance['display'];

		/** if the photo is < 1, set it to 1 **/
		if ( $count < 1 )
			$count = 1;
		
		/** if the widget have an ID, we can continue **/
		if ( !empty( $flickr_id ) ) {
		
			/** print the before widget **/
			echo $before_widget;
			
			if ( $title )
				echo $before_title . $title . $after_title;
		
			/** get the user direction, rtl or ltr **/
			if ( function_exists( 'is_rtl' ) )
				$dir= is_rtl() ? 'rtl' : 'ltr';

			/** wrap the widget **/
?>			<?php  if (!empty( $instance['intro_text'] ) ) echo '<p>' . do_shortcode( $instance['intro_text'] ) . '</p>'; ?>
			<div class="zframe-flickr-wrap-<?php echo $dir; ?>">
				<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $count; ?>&amp;display=<?php echo $display; ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type;?>&amp;<?php echo $type;?>=<?php echo $flickr_id; ?>"></script>
			</div>
			<div style="clear:both;">&nbsp;</div>
			<?php  if (!empty( $instance['outro_text'] ) ) echo '<p>' . do_shortcode( $instance['outro_text'] ) . '</p>'; ?>

<?php		/** print the after widget **/
			echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']		= strip_tags($new_instance['title']);
		$instance['intro_text'] = $new_instance['intro_text'];
		$instance['outro_text']	= $new_instance['outro_text'];
		$instance['type'] 		= strip_tags($new_instance['type']);
		$instance['flickr_id'] 	= strip_tags($new_instance['flickr_id']);
		$instance['count'] 		= (int) $new_instance['count'];
		$instance['display'] 	= strip_tags($new_instance['display']);
		
		return $instance;
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$type = isset($instance['type']) ? esc_attr($instance['type']) : 'user';
		$intro_text = $instance['intro_text'];
		$outro_text	= $instance['outro_text'];
		$flickr_id = isset($instance['flickr_id']) ? esc_attr($instance['flickr_id']) : '';
		$count = isset($instance['count']) ? absint($instance['count']) : 3;
		$display = isset( $instance['display'] ) ? $instance['display'] : 'latest';
		?>
		
		<div class="zframe-widget-controls columns-2">
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', $this->textdomain); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'intro_text' ); ?>"><?php _e('Intro Text:', $this->textdomain ) ?></label><br />
				<textarea name="<?php echo $this->get_field_name( 'intro_text' ); ?>" id="<?php echo $this->get_field_id( 'intro_text' ); ?>" rows="4" class="widefat"><?php echo htmlentities($instance['intro_text']); ?></textarea>
				<code>This field support HTML.</code>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e( 'Type:', $this->textdomain ); ?></label>
				<select class="column-last" name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" class="widefat">
					<option value="user"<?php selected($type,'user');?>>User</option>
					<option value="group"<?php selected($type,'group');?>>Group</option>
				</select>
			</p>
			
			<p><label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('Flickr ID (<a href="http://www.idgettr.com" target="_blank">idGettr</a>):', $this->textdomain); ?></label>
			<input class="column-last" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $flickr_id; ?>" /></p>
			
			<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of photo to show:', $this->textdomain); ?></label>
			<input class="column-last" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="3" /></p>
			
			<p><label for="<?php echo $this->get_field_id('display'); ?>"><?php _e('Display method:', $this->textdomain); ?></label>
			<select  class="column-last" id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>">
				<option<?php if($display == 'latest') echo ' selected="selected"'?> value="latest"><?php _e('Latest', $this->textdomain); ?></option>
				<option<?php if($display == 'random') echo ' selected="selected"'?> value="random"><?php _e('Random', $this->textdomain); ?></option>
			</select></p>
			<p>
				<label for="<?php echo $this->get_field_id( 'outro_text' ); ?>"><?php _e('Outro Text:', $this->textdomain ) ?></label><br />
				<textarea name="<?php echo $this->get_field_name( 'outro_text' ); ?>" id="<?php echo $this->get_field_id( 'outro_text' ); ?>" rows="4" class="widefat"><?php echo htmlentities($instance['outro_text']); ?></textarea>
				<code>This field support HTML.</code>
			</p>
			<p>
				<a href="http://feedburner.google.com/fb/a/mailverify?uri=zourbuth&amp;loc=en_US">Subscribe to zourbuth by Email</a><br />
				<?php _e( 'Like my work? Please consider to ', $this->textdomain ); ?><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=W6D3WAJTVKAFC" title="Donate"><?php _e( 'donate', $this->textdomain ); ?></a>.
			</p>

		</div>

		<div class="zframe-widget-controls envato-marketplace columns-2 column-last">
			<?php
				require_once 'Envato_marketplaces.php';
				$Envato = new Envato_marketplaces();
				$Envato->display_thumbs('zourbuth', 'codecanyon', '5');
			?>
			<br class="clear" />
			<p>
				<br />
				&copy; Copyright <a href="http://zourbuth.com">zourbuth</a> 2011.
			</p>
		</div>
		
		<div class="clear"></div>
		<?php
	}
}