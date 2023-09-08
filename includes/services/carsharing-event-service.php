<?php

defined( 'ABSPATH' ) or die;

class Carsharing_Event_Service
{
    private static $events = [];
    
    public static function listen( string $event, callable $callback )
    {
        self::$events[ $event ][] = $callback;
    }
    
    public static function trigger( string $event, array $data = [] )
    {
        $callbacks = self::$events[ $event ] ?? [];
        foreach ( $callbacks as $callback ) {
            call_user_func_array( $callback, $data );
        }
    }
}