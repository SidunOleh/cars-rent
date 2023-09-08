<?php

defined( 'ABSPATH' ) or die;

/**
 * Register hooks
 */
class Carsharing_Core
{
    public function run()
    {
        $this->load_dependecies();
        $this->post_types_hooks();
        $this->admin_hooks();
        $this->admin_ajax_hooks();
        $this->public_ajax_hooks();
        $this->events();
    }

    private function load_dependecies()
    {
        require_once CARSHARING_ROOT . '/includes/post-types/carsharing-car-post-type.php';
        require_once CARSHARING_ROOT . '/includes/pages/admin/carsharing-main-admin-page.php';
        require_once CARSHARING_ROOT . '/includes/controllers/admin/carsharing-orders-admin-controller.php';
        require_once CARSHARING_ROOT . '/includes/controllers/admin/carsharing-prices-admin-controller.php';
        require_once CARSHARING_ROOT . '/includes/controllers/admin/carsharing-settings-admin-controller.php';
        require_once CARSHARING_ROOT . '/includes/controllers/public/carsharing-public-controller.php';
        require_once CARSHARING_ROOT . '/includes/controllers/admin/carsharing-charts-admin-controller.php';
        require_once CARSHARING_ROOT . '/includes/services/carsharing-event-service.php';
        require_once CARSHARING_ROOT . '/includes/listeners/carsharing-new-order-notify-listener.php';
        require_once CARSHARING_ROOT . '/includes/listeners/carsharing-order-payed-notify-listener.php';
        require_once CARSHARING_ROOT . '/includes/functions.php';
        add_action( 'after_setup_theme', fn() => \Carbon_Fields\Carbon_Fields::boot() );
    }

    private function post_types_hooks()
    {
        $car_post_type = new Carsharing_Car_Post_Type;
        add_action( 'init', [ $car_post_type, 'register' ] );
        add_action( 'carbon_fields_register_fields', [ $car_post_type, 'metafields' ] );
        add_filter( 'template_include', [ $car_post_type, 'single_page_template' ] );
        add_action( 'wp_enqueue_scripts', [ $car_post_type, 'enqueue_styles' ] );
        add_action( 'wp_enqueue_scripts', [ $car_post_type, 'enqueue_scripts' ] );
    }

    private function admin_hooks()
    {
        $main_admin_page = new Carsharing_Main_Admin_Page;
        add_action( 'admin_menu', [ $main_admin_page, 'add_page' ] );
        add_action( 'admin_enqueue_scripts', [ $main_admin_page, 'enqueue_styles' ] );
        add_action( 'admin_enqueue_scripts', [ $main_admin_page, 'enqueue_scripts' ] );
    }

    private function admin_ajax_hooks()
    {
        $orders_admin_controller = new Carsharing_Orders_Admin_Controller;
        ajax_callback( 'get_orders_admin', [ $orders_admin_controller, 'get' ] );
        ajax_callback( 'delete_order_admin', [ $orders_admin_controller, 'delete' ] );
        ajax_callback( 'change_order_pay_status_admin', [ $orders_admin_controller, 'change_pay_status' ] );
        ajax_callback( 'create_order_admin', [ $orders_admin_controller, 'create' ] );
        ajax_callback( 'get_latest_admin', [ $orders_admin_controller, 'latest' ] );
        ajax_callback( 'change_day_off', [ $orders_admin_controller, 'change_day_off' ] );

        $prices_admin_controller = new Carsharing_Prices_Admin_Controller;        
        ajax_callback( 'get_prices_admin', [ $prices_admin_controller, 'get' ] );
        ajax_callback( 'save_prices_admin', [ $prices_admin_controller, 'save' ] );

        $settings_admin_controller = new Carsharing_Settings_Admin_Controller;
        ajax_callback( 'save_settings_admin', [ $settings_admin_controller, 'save' ] );

        $charts_admin_controller = new Carsharing_Charts_Admin_Controller;
        ajax_callback( 'get_charts_admin', [ $charts_admin_controller, 'get' ] );
    }

    private function public_ajax_hooks()
    {
        $public_controller = new Carsharing_Public_Controller;
        ajax_callback( 'get_days', [ $public_controller, 'get_days' ], true ); 
        ajax_callback( 'get_slots', [ $public_controller, 'get_slots' ], true );
        ajax_callback( 'create_order', [ $public_controller, 'create_order' ], true );
        ajax_callback( 'stripe_success', [ $public_controller, 'stripe_success' ], true );
        ajax_callback( 'stripe_cancel', [ $public_controller, 'stripe_cancel' ], true );
    }

    private function events()
    {
        Carsharing_Event_Service::listen( 
            'new_order',
            new Carsharing_New_Order_Notify_Listener 
        );
        Carsharing_Event_Service::listen( 
            'order_payed', 
            new Carsharing_Order_Payed_Notify_Listener 
        );
    }
}