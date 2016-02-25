<?php
//add nonce field for email signature
wp_nonce_field( 'email_signature_nonce', 'email_signature_nonce', false );
?>
<h2>Email Signature</h2>
<?php
//output buffer starts
ob_start();

//fetch data of email signature
echo get_usermeta( $user->ID, '_email_signature', true );

//outbuffer clean
$default = ob_get_clean();

//id for editor field
$editor_id = 'email_signature';

//options for editor
$option = array(
    'textarea_rows' => 7
);
//editor for signature
wp_editor( $default, $editor_id, $option );
