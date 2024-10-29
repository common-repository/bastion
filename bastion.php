<?php
/**
 * Plugin Name: Bastion
 * Author: Agence Harsene
 * Description: The modules needed to secure a WordPress site. Change the login page, limiting the number of login attempts.
 * Version: 1.0.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: bastion
 * Domain Path: /languages
 */
use function Bastion\Dependencies\LaunchpadCore\boot;

defined( 'ABSPATH' ) || exit;


require __DIR__ . '/vendor-prefixed/wp-launchpad/core/inc/boot.php';

boot( __FILE__ );
