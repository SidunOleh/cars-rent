<?php

defined( 'ABSPATH' ) or die;

class Carsharing_Cache_Service
{    
    public function set( string $key, $value, int $expiration ): bool
    {
        return set_transient( 
            $key,
            $value,
            $expiration
        );
    }

    public function get( string $key )
    {
        return get_transient( $key );
    }
}