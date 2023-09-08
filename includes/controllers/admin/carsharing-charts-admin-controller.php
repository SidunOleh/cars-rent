<?php

defined( 'ABSPATH' ) or die;

require_once CARSHARING_ROOT . '/includes/controllers/carsharing-controller.php';
require_once CARSHARING_ROOT . '/includes/models/carsharing-order.php';

class Carsharing_Charts_Admin_Controller extends Carsharing_Controller
{
    private $order_model;

    public function __construct()
    {
        $this->order_model = new Carsharing_Order;
    }

    public function get()
    {
        $year = $_GET[ 'year' ] ?: null;
        $month = $_GET[ 'month' ] ?: null;

        $orders_statistic = 
            $this->order_model->statistic( $year, $month );
        
        $this->json_response( [
            'orders_statistic' => $orders_statistic,
        ] );
    }
}