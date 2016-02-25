<?php
//namespace for class
namespace rtCamp\WP\rtEmailSignature;

if ( !class_exists( 'Email_Signature' ) ) {

	/**
	 * Email signature
	 *
	 * @author Vaishali Agola <vaishaliagola27@gmail.com>
	 */
	class Email_Signature {

		public function init() {
			//setting page for advertisement
			add_action( 'edit_user_profile', array( $this, 'email_signature_setting' ) );
			add_action( 'show_user_profile', array( $this, 'email_signature_setting' ) );

			//save image of advertisement
			add_action( 'personal_options_update', array( $this, 'save_email_signature' ) );
			add_action( 'edit_user_profile_update', array( $this, 'save_email_signature' ) );
			
			//enqueue js for display
			add_action( 'admin_enqueue_scripts', array( $this, 'wp_admin_enqueue_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'wp_admin_enqueue_scripts' ) );
		}

		/**
		 * add email signature meta box
		 * 
		 * @param array $user	array of user data
		 */
		public function email_signature_setting( $user ) {
			//include file for html
			require \rtCamp\WP\rtEmailSignature\PATH . 'includes/views/email-signature-admin.php';
		}

		/**
		 * save user meta for email signature
		 * 
		 * @param int $user_id
		 * @return boolean
		 */
		public function save_email_signature( $user_id ) {
			//check user permision 
			if ( !current_user_can( 'edit_user', $user_id ) )
				return false;

			if ( empty( $user_id ) ) {
				$user_id = $_POST[ 'user_id' ];
			}

			if ( empty( $user_id ) ) {
				return;
			}

			//verify nonce
			$sign_nonce = !empty( $_POST[ 'email_signature_nonce' ] ) ? $_POST[ 'email_signature_nonce' ] : '';

			if ( empty( $sign_nonce ) ) {
				return;
			}
			//verify nonce for signature
			if ( !wp_verify_nonce( $_POST[ 'email_signature_nonce' ], 'email_signature_nonce' ) ) {
				return;
			}

			//update usermeta of email signature
			update_usermeta( $user_id, '_email_signature', $_POST[ 'email_signature' ] );
		}
		
		/**
		 * enqueue script for email signature and display it in data
		 * 
		 * @param string $hook
		 */
		public function wp_admin_enqueue_scripts($hook){
			//enqueue script
			wp_register_script( 'rt_email-signature-js', \rtCamp\WP\rtEmailSignature\URL . '/assets/js/signature_display.js' );
			wp_enqueue_script( 'rt_email-signature-js' );
			
			$args = array(
			    'id' => 'followupcontent',
			    'content' => html_entity_decode(get_usermeta( wp_get_current_user()->ID,'_email_signature'))
			);
			
			/**
			 * filter to change arguments for localize the script
			 * 
			 * @param string $var filter name
			 * @param array $args array of arguments
			 */
			$args = apply_filters('rt_email_signature_arguments',$args);
			
			//localize the script for variable access
			wp_localize_script( 'rt_email-signature-js', 'email_signature', $args );
		}
	}

}