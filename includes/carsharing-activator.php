<?php

defined( 'ABSPATH' ) or die;

require_once ABSPATH . '/wp-admin/includes/upgrade.php';

/**
 * Activate plugin
 */
class Carsharing_Activator
{   
    public function activate()
    {
        $this->create_carsharing_orders_table();
        $this->create_carsharing_prices_table();
        $this->create_carsharing_days_off_table();
    }

    /**
     * Create carsharing orders table
    */
    private function create_carsharing_orders_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $base_prefix = $wpdb->base_prefix;

        $sql = "CREATE TABLE IF NOT EXISTS {$base_prefix}carsharing_orders (
            id                BIGINT(20)    UNSIGNED NOT NULL  AUTO_INCREMENT,
            car_id            BIGINT(20)    UNSIGNED NOT NULL,
            start             DATETIME               NOT NULL,
            end               DATETIME               NOT NULL,
            client_name       VARCHAR(100)           NOT NULL,
            client_phone      VARCHAR(100)           NOT NULL,
            client_email      VARCHAR(100)           NOT NULL,
            client_photo      VARCHAR(255)           NOT NULL,
            price             DECIMAL(15, 2)         NOT NULL,
            stripe_session_id VARCHAR(100)           NULL,
            payed             BOOLEAN                NOT NULL  DEFAULT false,
            options           JSON                   NULL,
            comment           TEXT                   NULL,
            created_at        DATETIME               NOT NULL, 
            PRIMARY KEY(id)
        ) AUTO_INCREMENT = 10000 {$charset_collate}";
        
        dbDelta( $sql );

        if ( $wpdb->last_error ) die( $wpdb->last_error );
    }

    /**
     * Create carsharing prices table
    */
    private function create_carsharing_prices_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $base_prefix = $wpdb->base_prefix;

        $sql = "CREATE TABLE IF NOT EXISTS {$base_prefix}carsharing_prices (
            id     BIGINT(20) UNSIGNED NOT NULL  AUTO_INCREMENT,
            car_id BIGINT(20) UNSIGNED NOT NULL,
            date   DATE                NULL,
            prices JSON                NOT NULL,
            PRIMARY KEY(id)
        ) {$charset_collate}";
        
        dbDelta( $sql );

        if ( $wpdb->last_error ) die( $wpdb->last_error );
    }

    /**
     * Create carsharing days off table
    */
    private function create_carsharing_days_off_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $base_prefix = $wpdb->base_prefix;

        $sql = "CREATE TABLE IF NOT EXISTS {$base_prefix}carsharing_days_off (
            id     BIGINT(20) UNSIGNED NOT NULL  AUTO_INCREMENT,
            car_id BIGINT(20) UNSIGNED NOT NULL,
            date   DATE                NOT NULL,
            PRIMARY KEY(id)
        ) {$charset_collate}";
        
        dbDelta( $sql );

        if ( $wpdb->last_error ) die( $wpdb->last_error );
    }

    public function activated( $plugin )
    {
        if ( $plugin == 'carsharing/carsharing.php' ) {
            die( wp_redirect( admin_url( 'admin.php?page=cars-rent#settings' ) ) );
        } 
    }
}