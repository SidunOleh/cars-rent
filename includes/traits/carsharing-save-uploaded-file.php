<?php

defined( 'ABSPATH' ) or die;

trait Carsharing_Save_Uploaded_File
{
    protected function save_file( array $uploaded_file, $to ): string|bool
    {
        $extension = explode( '.', $uploaded_file[ 'name' ] )[1];
        $name = md5( $uploaded_file[ 'name' ] . time() ) . '.' . $extension;
        $path = "{$to}/{$name}";

        $result = move_uploaded_file( 
            $uploaded_file[ 'tmp_name' ],  
            CARSHARING_ROOT . $path
        );

        return $result ? $path : false;
    }
}