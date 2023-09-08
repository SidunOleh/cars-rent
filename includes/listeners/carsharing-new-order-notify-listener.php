<?php

defined( 'ABSPATH' ) or die;

class Carsharing_New_Order_Notify_Listener
{
    public function __invoke( $order )
    {
        $message = template_read( 
            CARSHARING_ROOT . '/includes/templates/admin/emails/new-order.php', 
            compact( 'order' )
        );

        wp_mail(
            get_carsharing_option( 'notification_email' ) ?: get_option( 'admin_email' ),
            __( 'New Order' ),
            $message
        );
        wp_mail(
            $order->client_email,
            __( 'New Order' ),
            $message
        );
    }
}