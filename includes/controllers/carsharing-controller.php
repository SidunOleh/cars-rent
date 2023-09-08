<?php

defined( 'ABSPATH' ) or die;

abstract class Carsharing_Controller
{
    protected function json_response( array $data, $code = 200 )
    {
        wp_send_json( $data, $code );
        die;
    }

    protected function redirect( $url, $code = 301 )
    {
        header( "Location: {$url}", true, $code );
        die;
    }
}