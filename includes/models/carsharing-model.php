<?php

defined( 'ABSPATH' ) or die;

require_once CARSHARING_ROOT . '/includes/traits/carsharing-save-uploaded-file.php';

abstract class Carsharing_Model
{
    use Carsharing_Save_Uploaded_File;
    
    protected $db;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
    }
}