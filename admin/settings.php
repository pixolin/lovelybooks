<?php

/**
 * Class LBsettings
 */
class LBsettings {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'lb_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'lb_register_setting' ) );
	}

	public function lb_admin_menu() {
		add_options_page( 'LovelyBooks', 'LovelyBooks', 'manage_options', 'lovelybooks', array( $this, 'lb_settings_page' ) );

		wp_enqueue_style( 'wp-color-picker' );
	}

	public function lb_settings_page() {
		echo '<h1>' . __( 'Settings', 'lovelybooks' ) . '</h1>';

		echo '<form action="options.php" method="post">';
		settings_fields( 'lbsettings' );
		do_settings_sections( 'lovelybooks' );
		submit_button( __( 'Save Changes' ), $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null );
		echo '</form></div>';

	}

	public function lb_register_setting() {
		register_setting( 'lbsettings', 'lbsettings', $sanitize_callback = array( $this, 'sanitize' ) );

		add_settings_section(
			$id       = 'lb_section',
			$title    = '',
			$callback = array( $this, 'lb_settings_section' ),
			$page     = 'lovelybooks'
		);

		add_settings_field(
			$id       = 'lb_userid',
			$title    = __( 'User ID', 'lovelybooks' ),
			$callback = array( $this, 'lb_userid_function' ),
			$page     = 'lovelybooks',
			$section  = 'lb_section',
			$args     = array()
		);

		add_settings_field(
			$id       = 'lb_variant',
			$title    = __( 'Variant', 'lovelybooks' ),
			$callback = array( $this, 'lb_variant_function' ),
			$page     = 'lovelybooks',
			$section  = 'lb_section',
			$args     = array()
		);

		add_settings_field(
			$id       = 'lb_bgcolor',
			$title    = __( 'Background Color', 'lovelybooks' ),
			$callback = array( $this, 'lb_bgcolor_function' ),
			$page     = 'lovelybooks',
			$section  = 'lb_section',
			$args     = array()
		);
		add_settings_field(
			$id       = 'lb_acolor',
			$title    = __( 'Accent Color', 'lovelybooks' ),
			$callback = array( $this, 'lb_acolor_function' ),
			$page     = 'lovelybooks',
			$section  = 'lb_section',
			$args     = array()
		);
		add_settings_field(
			$id       = 'lb_color',
			$title    = __( 'Primary Text Color', 'lovelybooks' ),
			$callback = array( $this, 'lb_pcolor_function' ),
			$page     = 'lovelybooks',
			$section  = 'lb_section',
			$args     = array()
		);

	}

	public function lb_settings_section() {
		_e( 'Please enter your settings for the Lovelybooks Widget','lovelybooks' );
	}

	public function lb_userid_function() {
		$options = get_option( 'lbsettings' );
		if ( $options['userid'] ) {
			$userid = $options['userid'];
		} else {
			$userid = '18438024';
		}
		echo '<input id="userid" name="lbsettings[userid]" size="12" type="text" value="' . esc_attr( $userid ) . '" />';
	}

	public function lb_variant_function() {
		$options = get_option( 'lbsettings' );
		if ( $options['variant'] ) {
			$variant = $options['variant'];
		} else {
			$variant = '1';
		}
		echo '<select name="lbsettings[variant]">';
		echo '<option value="1" ' . selected( $variant, '1', true ) . '>1</option>';
		echo '<option value="2" ' . selected( $variant, '2', true ) . '>2</option>';
		echo '</select><br>';

	}

	public function lb_bgcolor_function() {
		$options = get_option( 'lbsettings' );
		if ( $options['bgcolor'] ) {
			$bgcolor = $options['bgcolor'];
		} else {
			$bgcolor = '';
		}
		echo '<input id="bgcolor" class="colorfield" data-default-color="#ffffff" name="lbsettings[bgcolor]" size="7" type="text" value="' . esc_attr( $bgcolor ) . '" />';
	}

	public function lb_acolor_function() {
		$options = get_option( 'lbsettings' );
		if ( $options['acolor'] ) {
			$acolor = $options['acolor'];
		} else {
			$acolor = '';
		}
		echo '<input id="acolor" class="colorfield" data-default-color="#e6a117" name="lbsettings[acolor]" size="7" type="text" value="' . esc_attr( $acolor ) . '" />';
	}

	public function lb_pcolor_function() {
		$options = get_option( 'lbsettings' );
		if ( $options['pcolor'] ) {
			$pcolor = $options['pcolor'];
		} else {
			$pcolor = '';
		}
		echo '<input id="pcolor" class="colorfield" data-default-color="#7c7d7f" name="lbsettings[pcolor]" size="7" type="text" value="' . esc_attr( $pcolor ) . '" />';
	}


	public function sanitize( $input ) {

		// Initialize the new array that will hold the sanitize values
		$new_input = array();

		// Loop through the input and sanitize each of the values
		foreach ( $input as $key => $val ) {

			switch ( $key ) {

				case 'userid':
				case 'variant':
					$new_input[ $key ] = absint( $val );
					break;

				case 'bgcolor':
				case 'acolor':
				case 'pcolor':
					$new_input[ $key ] = sanitize_hex_color( $val );
					break;
			}
		}

		return $new_input;
	}
}
