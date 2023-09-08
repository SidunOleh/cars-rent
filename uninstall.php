<?php

defined( 'WP_UNINSTALL_PLUGIN' ) or die;

global $wpdb;
// delete orders table
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->base_prefix}carsharing_orders" );
// delete prices table
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->base_prefix}carsharing_prices" );
// delete days off table
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->base_prefix}carsharing_days_off" );