<?php

defined( 'ABSPATH' ) or die;

class Carsharing_Validation_Exception extends Exception
{
    private $errors;

    public function __construct( array $errors = [], $message = '', $code = 0, Throwable $previous = null ) {
        $this->errors = $errors;

        parent::__construct( $message, $code, $previous );
    }

    public function getErrors()
    {
        return $this->errors;
    }
}