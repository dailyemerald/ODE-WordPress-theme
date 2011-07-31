<?php

if ( !class_exists( 'ode_post' ) ) {
	
class ode_post
{
	
	function __construct() {
		
		// Set up metabox and related actions
		add_action('admin_menu', array(&$this, 'add_post_meta_box'));
		add_action('save_post', array(&$this, 'save_post_meta_box'));
		add_action('edit_post', array(&$this, 'save_post_meta_box'));
		add_action('publish_post', array(&$this, 'save_post_meta_box'));
		
	}
	
	function add_post_meta_box() {
		global $ode;
		
		add_meta_box( 'ode-custom-byline', __( 'ODE Custom Byline', 'ode' ), array( &$this, 'post_meta_box' ), 'post', 'side' );
	}	
	
	function post_meta_box() {
		global $post, $ode;

		$custom_byline = get_post_meta( $post->ID, '_cp_byline', true );	

		?>
		
		<p><input type="text" id="ode_post-custom_byline" name="ode_post-custom_byline" value="<?php echo esc_html( $custom_byline ); ?>" size="30" /></p>
		<p class="description">Entering a value in this field will override the WordPress author field.</p>
				
		<input type="hidden" name="ode_post-nonce" id="ode_post-nonce" value="<?php echo wp_create_nonce('ode_post-nonce'); ?>" />

		<?php 

	}
	
	function save_post_meta_box() {
		global $ode, $post;

		if ( !wp_verify_nonce( $_POST['ode_post-nonce'], 'ode_post-nonce')) {
			return $post->ID;  
		}

		if ( !wp_is_post_revision( $post ) && !wp_is_post_autosave( $post ) ) {
			
			$custom_byline = strip_tags( $_POST['ode_post-custom_byline'] );
			update_post_meta( $post->ID, '_cp_byline', $custom_byline );
			
		}
		
	}
	
}	
	
}