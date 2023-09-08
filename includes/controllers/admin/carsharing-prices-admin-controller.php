<?php

defined( 'ABSPATH' ) or die;

require_once CARSHARING_ROOT . '/includes/controllers/carsharing-controller.php';
require_once CARSHARING_ROOT . '/includes/models/carsharing-price.php';

class Carsharing_Prices_Admin_Controller extends Carsharing_Controller
{
    private $price_model;

    public function __construct()
    {
        $this->price_model = new Carsharing_Price;
    }

    public function get()
    {
        $car_id = $_GET[ 'car_id' ];
        $date = datetime( $_GET[ 'date' ] );

        $default_prices = $this->price_model->get( $car_id );
        $date_prices = $this->price_model->get( $car_id, $date );

        $prices_html = template_read( 
            CARSHARING_ROOT . '/includes/templates/admin/parts/prices.php', 
            compact( 'default_prices', 'date_prices' ) 
        );

        $this->json_response( [
            'prices_html' => $prices_html,
        ] );
    }

    public function save()
    {
        $car_id = $_POST[ 'car_id' ];
        $date = datetime( $_POST[ 'date' ] );
        $default_prices = $_POST[ 'default_prices' ];
        $date_prices = $_POST[ 'date_prices' ];

        $this->price_model->save( $default_prices, $car_id );
        $this->price_model->save( $date_prices, $car_id, $date );

        $this->json_response( [
            'message' => 'OK',
        ] );
    }
}