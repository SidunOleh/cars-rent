<?php

defined( 'ABSPATH' ) or die;

require_once CARSHARING_ROOT . '/includes/controllers/carsharing-controller.php';

class Carsharing_Settings_Admin_Controller extends Carsharing_Controller
{
    public function save()
    {
        $settings = $_POST[ 'settings' ] ?? [];

        update_option( 'carsharing_settings', $settings );

        $this->json_response( [
            'message' => 'OK',
        ] );
    }
}