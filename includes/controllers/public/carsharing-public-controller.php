<?php

defined( 'ABSPATH' ) or die;

require_once CARSHARING_ROOT . '/includes/controllers/carsharing-controller.php';
require_once CARSHARING_ROOT . '/includes/models/carsharing-order.php';
require_once CARSHARING_ROOT . '/includes/exceptions/carsharing-validation-exception.php';
require_once CARSHARING_ROOT . '/includes/services/carsharing-stripe-service.php';
require_once CARSHARING_ROOT . '/includes/services/carsharing-event-service.php';

class Carsharing_Public_Controller extends Carsharing_Controller
{
    private $order_model;

    public function __construct()
    {
        $this->order_model = new Carsharing_Order;
    }

    public function get_days()
    {
        $year = $_GET[ 'year' ];
        $month = $_GET[ 'month' ];
        $car_id = $_GET[ 'car_id' ];
        $days = $this->order_model->get_days( $year, $month, $car_id );

        $this->json_response( [
            'days' => $days,
        ] );
    }

    public function get_slots()
    {
        $start = datetime( $_GET[ 'date' ] . ' ' . $_GET[ 'hour' ] );
        $car_id = $_GET[ 'car_id' ];

        $slots = $this->order_model->get_slots( $start, $car_id );
        $slots_html = template_read(
            CARSHARING_ROOT . '/includes/templates/public/parts/slots.php',
            [ 'slots' => $slots, ]
        );

        $this->json_response( [
            'slots_html' => $slots_html,
        ] );
    }

    public function create_order()
    {
        $data = array_merge( $_POST, $_FILES );
        
        try {
            $order = $this->order_model->create( $data );
            Carsharing_Event_Service::trigger( 'new_order', [ $order, ] );
        } catch ( Carsharing_Validation_Exception $e ) {
            $this->json_response( [
                'error' => $e->getErrors()[0],
            ], 422 );
        }

        $session = ( new Carsharing_Stripe_Service )->order_session( $order );
        
        $this->order_model->update(
            [ 'stripe_session_id' => $session->id, ],
            [ 'id' => $order->id, ],
        );

        $this->json_response( [
            'status' => 301,
            'url' => $session->url,
        ] );
    }

    public function stripe_success()
    {
        $session_id = $_GET[ 'session_id' ]; 

        $this->order_model->update(
            [ 'payed' => true, ],
            [ 'stripe_session_id' => $session_id, ],
        );

        $order = $this->order_model
            ->get_by_stripe_session_id( $session_id );
        Carsharing_Event_Service::trigger( 'order_payed', [ $order, ] );

        $this->redirect( '/success' );
    }

    public function stripe_cancel()
    {
        $this->redirect( '/cancel' );
    }
}