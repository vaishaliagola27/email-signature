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

	}

}