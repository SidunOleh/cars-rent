<?php

defined( 'ABSPATH' ) or die;

require_once CARSHARING_ROOT . '/includes/controllers/carsharing-controller.php';
require_once CARSHARING_ROOT . '/includes/models/carsharing-order.php';
require_once CARSHARING_ROOT . '/includes/exceptions/carsharing-validation-exception.php';

class Carsharing_Orders_Admin_Controller extends Carsharing_Controller
{
    private $order_model;

    public function __construct()
    {
        $this->order_model = new Carsharing_Order;
    }

    public function get()
    {
        $date = datetime( $_GET[ 'date' ] );
        $car_id = $_GET[ 'car_id' ];

        $orders = $this->order_model->get_by_date( $date, $car_id );
        $orders_html = template_read( 
            CARSHARING_ROOT . '/includes/templates/admin/parts/orders.php', 
            compact( 'orders' ) 
        );

        $day_off = $this->order_model->is_day_off( $date, $car_id );

        $this->json_response( [
            'orders_html' => $orders_html,
            'day_off' => $day_off,
        ] );
    }

    public function latest()
    {
        $page = $_GET[ 'page' ];
        $per_page = 6;
        $latest = $this->order_model->latest( $page, $per_page );
        $orders_total_count = $this->order_model->total();

        $latest_html = template_read( 
            CARSHARING_ROOT . '/includes/templates/admin/pages/latest.php', 
            compact( 
                'latest', 
                'page', 
                'per_page',
                'orders_total_count'
            ) 
        );

        $this->json_response( [
            'latest_html' => $latest_html,
        ] );
    }

    public function delete()
    {
        $order_id = $_POST[ 'order_id' ];

        $this->order_model->delete( $order_id );

        $this->json_response( [
            'message' => 'OK',
        ] );
    }

    public function change_pay_status()
    {
        $order_id = $_POST[ 'order_id' ];

        $this->order_model->change_pay_status( $order_id );

        $this->json_response( [
            'message' => 'OK',
        ] );
    }

    public function create()
    {
        $data = array_merge( $_POST, $_FILES );

        try {
            $order = $this->order_model->create( $data );
        } catch ( Carsharing_Validation_Exception $e ) {
            $this->json_response( [
                'error' => $e->getErrors()[0],
            ], 422 );
        }

        $order_html = template_read( 
            CARSHARING_ROOT . '/includes/templates/admin/parts/order.php', 
            compact( 'order' ) 
        );

        $this->json_response( [
            'order_html' => $order_html,
        ] );
    } 

    public function change_day_off()
    {
        $date = datetime( $_POST[ 'date' ] );
        $car_id = $_POST[ 'car_id' ]; 

        $this->order_model->change_day_off( $date, $car_id );

        $this->json_response( [
            'message' => 'OK',
        ] );
    }
}