<?php

defined( 'ABSPATH' ) or die;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class Carsharing_Stripe_Service
{
    private $stripe_key;

    private $stripe_secret;

    private $success_url;

    private $cancel_url;

    public function __construct()
    {
        $this->stripe_key = 
            get_carsharing_option( 'stripe_key' );
        $this->stripe_secret = 
            get_carsharing_option( 'stripe_secret' );
        $this->success_url = 
            admin_url( 'admin-ajax.php?action=stripe_success&session_id={CHECKOUT_SESSION_ID}' );
        $this->cancel_url = 
            admin_url( 'admin-ajax.php?action=stripe_cancel' );

        Stripe::setApiKey( $this->stripe_secret );
    }

    public function order_session( $order )
    {
        $car_title = get_the_title( $order->car_id );
        $car_img = get_the_post_thumbnail_url( $order->car_id, 'full' );
        $rent_start = datetime( $order->start )
            ->format( 'm/d/Y h:i A' );
        $rent_end = datetime( $order->end )
            ->format( 'm/d/Y h:i A' );
        $price = ( float ) $order->price * 100;
        $line_item = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => sprintf( 
                        __( 'Rent %s From %s To %s' ), 
                        $car_title, 
                        $rent_start,
                        $rent_end 
                    ),
                    'images' => [ $car_img ],
                ],
                'unit_amount' => $price,
            ],
            'quantity' => 1,
        ];

        $session = Session::create( [
            'line_items' => [ $line_item ], 
            'mode' => 'payment',
            'success_url' => $this->success_url,
            'cancel_url' => $this->cancel_url,
        ] );

        return $session;
    }
}