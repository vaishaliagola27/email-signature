<?php

/*
  Plugin Name: rtEmailSignature
  Plugin URI:  http://rtcamp.com
  Description: Restaurat directory
  Version:     0.1
  Author:      vaishuagola27
  Author URI:  http://rtcamp.com
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Domain Path: /languages
  Text Domain: rt-restaurants
 */
// Custom code starts here
//namespace declaration

namespace rtCamp\WP\rtEmailSignature;

//define constant for plugin directory path
define( 'rtCamp\WP\rtEmailSignature\PATH', plugin_dir_path( __FILE__ ) );

//define constant for plugin directory url
define( 'rtCamp\WP\rtEmailSignature\URL', plugin_dir_url( __FILE__ ) );

//include classes
require_once \rtCamp\WP\rtRestaurants\PATH . 'includes/class-email_signature.php';

//instanciate class Email_Signature and call init()
$email_signature = new Email_Signature();
$email_signature->init();