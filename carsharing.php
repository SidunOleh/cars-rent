<?php

/**
 * Plugin Name: Cars Rent
 * Description: Plugin for renting cars
 * Author: Sidun Oleh
 */

defined( 'ABSPATH' ) or die;

const CARSHARING_ROOT = __DIR__;

/**
 * Composer autoloader
 */
require_once CARSHARING_ROOT . '/vendor/autoload.php';

/**
 * Activate plugin
 */
require_once CARSHARING_ROOT . '/includes/carsharing-activator.php';
$activator = new Carsharing_Activator;
register_activation_hook( 
   __FILE__, 
   [ $activator, 'activate' ] 
);
add_action( 
  'activated_plugin', 
  [ $activator, 'activated' ] 
);

 /***
  * Run plugin
  */
require_once CARSHARING_ROOT . '/includes/carsharing-core.php';
( new Carsharing_Core )->run();