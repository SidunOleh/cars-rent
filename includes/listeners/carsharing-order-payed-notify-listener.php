<?php

defined( 'ABSPATH' ) or die;

class Carsharing_Order_Payed_Notify_Listener
{
    public function __invoke( $order )
    {
        $message = template_read( 
            CARSHARING_ROOT . '/includes/templates/admin/emails/order-payed.php', 
            compact( 'order' )
        );

        wp_mail(
            get_carsharing_option( 'notification_email' ) ?: get_option( 'admin_email' ),
            __( 'Order Payed' ),
            $message
        );
        wp_mail(
            $order->client_email,
            __( 'Order Payed' ),
            $message
        );
    }
}