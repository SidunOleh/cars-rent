<?php

defined( 'ABSPATH' ) or die;

class Carsharing_Main_Admin_Page
{
    public function add_page()
    {
        add_menu_page(
            __( 'Cars Rent' ),
            __( 'Cars Rent' ),
            'delete_others_posts',
            'cars-rent',
            [ $this, 'render_page' ],
            plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/admin/img/carsharing.png',
            21
        );
    }

    public function render_page()
    {
        require_once CARSHARING_ROOT . '/includes/templates/admin/pages/main.php';
    }

    public function enqueue_styles()
    {
        if ( ! in_array( $_GET[ 'page' ] ?? '', [ 'cars-rent', ] ) ) {
            return;
        }
            
        wp_enqueue_style( 
            'carsharing-admin', 
            plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/admin/css/style.css' 
        );

        wp_enqueue_style( 
            'calendar', 
            plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/admin/css/calendar.css' 
        );

        wp_enqueue_style( 
            'fancybox', 
            'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css' 
        );
    }

    public function enqueue_scripts()
    {
        if ( ! in_array( $_GET[ 'page' ] ?? '', [ 'cars-rent', ] ) ) {
            return;
        }

        wp_deregister_script( 'jquery' );
        wp_enqueue_script( 
            'jquery', 
            'https://code.jquery.com/jquery-3.7.0.min.js',
            [],
            false, 
            true
        );

        wp_enqueue_script( 
            'calendar', 
            plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/admin/js/calendar.js',
            [ 'jquery', ],
            false, 
            true
        );

        wp_enqueue_script( 
            'fancybox', 
            'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js',
            [],
            false, 
            true
        );

        wp_enqueue_script( 
            'chart', 
            'https://cdn.jsdelivr.net/npm/chart.js',
            [],
            false, 
            true
        );

        wp_enqueue_script( 
            'carsharing-admin', 
            plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/admin/js/script.js',
            [ 'jquery', 'calendar', 'fancybox', 'chart', ], 
            false, 
            true 
        );
        $jsData[ 'ajax_url'] = admin_url( 'admin-ajax.php' );
        wp_localize_script(
            'carsharing-admin',
            'carsharing',
            $jsData
        );
    }
}