<?php

defined( 'ABSPATH' ) or die();

class DFP_Widget extends WP_Widget {

	public static $outputted_script = false;

	/**
	 * Class constructor
	 *
	 * @author John Blackbourn
	 **/
	function __construct() {
		parent::WP_Widget( false, __( 'Google DFP', 'dfpw' ), array(
			'description' => __( 'Google DoubleClick for Publishers ad box', 'facetious' )
		) );
	}

	/**
	 * The widget output
	 *
	 * @param $args array The arguments for the current sidebar and current widget
	 * @param $instance array Specific arguments (eg. user-defined values) for the current widget instance
	 * @return null
	 * @author John Blackbourn
	 **/
    function widget( $args, $instance ) {

		if ( !self::$outputted_script ) {
			$this->output_script();
			self::$outputted_script = true;
		}

		echo $args['before_widget'];
		echo $instance['code'];
		echo $args['after_widget'];

	}

	/**
	 * The widget's options form
	 *
	 * @param $instance array Specific arguments (eg. user-defined values) for the current widget instance
	 * @author John Blackbourn
	 **/
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'code'  => '',
		) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Ad Name:', 'dfpw' ); ?></label>
			<input class="widefat" type="text"
				id="<?php echo $this->get_field_id( 'title' ); ?>"
				name="<?php echo $this->get_field_name( 'title' ); ?>"
				value="<?php echo esc_attr( $instance['title'] ); ?>"
			/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'code' ); ?>"><?php _e( 'Ad Code:', 'dfpw' ); ?></label>
			<textarea class="widefat" rows="8" type="text"
				id="<?php echo $this->get_field_id( 'code' ); ?>"
				name="<?php echo $this->get_field_name( 'code' ); ?>"><?php echo esc_textarea( $instance['code'] ); ?></textarea>
		</p>
		<p class="description"><?php _e( 'Put the "body" part of your ad code here.', 'dfpw' ); ?></p>

		<?php

	}

	/**
	 * Output the required DFP JavaScript
	 *
	 * @author John Blackbourn
	 * @return [type]   [description]
	 */
	function output_script() {
		?>
		<script type="text/javascript">
			var googletag = googletag || {};
			googletag.cmd = googletag.cmd || [];
			(function() {
				var gads = document.createElement('script');
				gads.async = true;
				gads.type = 'text/javascript';
				var useSSL = 'https:' == document.location.protocol;
				gads.src = (useSSL ? 'https:' : 'http:') +
					'//www.googletagservices.com/tag/js/gpt.js';
				var node = document.getElementsByTagName('script')[0];
				node.parentNode.insertBefore(gads, node);
			})();
		</script>
		<?php
	}

	function register() {
		register_widget( get_class() );
	}

}

add_action( 'widgets_init', array( 'DFP_Widget', 'register' ) );
