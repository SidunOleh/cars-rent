<?php

defined( 'ABSPATH' ) or die;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

require_once CARSHARING_ROOT . '/includes/post-types/carsharing-post-type.php';

class Carsharing_Car_Post_Type extends Carsharing_Post_Type
{
    protected function name(): string
    {
        return 'car';
    }

    protected function label(): string
    {
        return __( 'Car' );
    }

    protected function label_plular(): string
    {
        return __( 'Cars' );
    }

    protected function menu_icon(): string
    {
        return plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/admin/img/cars.png';
    }

    protected function supports(): array
    {
        return [ 'title', 'thumbnail', ];
    }

    protected function has_archive(): bool
    {
        return false;
    }

    public function metafields()
    {
        Container::make( 'post_meta', __( 'Car info' ) )
            ->where( 'post_type', '=', 'car' )
            ->add_tab( __( 'First section' ), [
                Field::make( 'image', 'first_bg', __( 'Background image' ) ),
                Field::make( 'text', 'first_title', __( 'Title' ) ),
                Field::make( 'rich_text', 'first_text', __( 'Text' ) ),
            ] )
            ->add_tab( __( 'Description' ), [
                Field::make( 'text', 'desc_title', __( 'Title' ) ),
                Field::make( 'rich_text', 'desc_text', __( 'Text' ) ),
            ] )
            ->add_tab( __( 'Characteristics' ), [
                Field::make( 'complex', 'prop_items', __( 'Characteristics' ) )
                    ->add_fields( [
                        Field::make( 'image', 'icon', __( 'Icon' ) ),
                        Field::make( 'text', 'name', __( 'Name' ) ),
                        Field::make( 'text', 'val', __( 'Value' ) ),
                    ] ),
            ] )
            ->add_tab( __( 'Advantages' ), [
                Field::make( 'complex', 'advan_items', __( 'Advantages' ) )
                    ->add_fields( [
                        Field::make( 'image', 'icon', __( 'Icon' ) ),
                        Field::make( 'text', 'title', __( 'Title' ) ),
                        Field::make( 'rich_text', 'text', __( 'Text' ) ),
                    ] ),
            ] )
            ->add_tab( __( 'Requirements' ), [
                Field::make( 'text', 'requirements_title', __( 'Title' ) ),
                Field::make( 'complex', 'requirements', __( 'Requirements' ) )
                    ->add_fields( [
                        Field::make( 'image', 'icon', __( 'Icon' ) ),
                        Field::make( 'text', 'text', __( 'Text' ) ),
                    ] ),
            ] )
            ->add_tab( __( 'Video' ), [
                Field::make( 'file', 'video', __( 'Video' ) )
                    ->set_type( 'video' ),
                Field::make( 'image', 'poster', __( 'Poster' ) ),
            ] )
            ->add_tab( __( 'Options' ), [
                Field::make( 'complex', 'rent_options', __( 'Rent options ' ) )
                    ->add_fields( [
                        Field::make( 'text', 'title', __( 'Option title' ) ),
                        Field::make( 'rich_text', 'text', __( 'Option text' ) ),
                        Field::make( 'complex', 'option', __( 'Option ' ) )
                            ->add_fields( [
                                Field::make( 'text', 'item', __( 'Item' ) ),
                                Field::make( 'text', 'price', __( 'Price($)' ) ),
                            ] ),
                    ] ),
            ] )
            ->add_tab( __( 'Rules' ), [
                Field::make( 'complex', 'rules', __( 'Rules' ) )
                    ->add_fields( [
                        Field::make( 'rich_text', 'text', __( 'Text' ) ),
                    ] ),
            ] )
            ->add_tab( __( 'Photo' ), [
                Field::make( 'text', 'photo_title', __( 'Title' ) ),
                Field::make( 'rich_text', 'photo_text', __( 'Text' ) ),
            ] );
    }

    public function single_page_template( $template )
    {
        if ( is_singular( 'car' ) ) {
            return locate_template( 'single-car.php' ) 
                ?: CARSHARING_ROOT . '/includes/templates/public/single-car.php';
        }

        return $template;
    }

    public function enqueue_styles()
    {
        if ( ! is_singular( 'car' ) ) return;

        wp_enqueue_style( 
            'calendar', 
            plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/admin/css/calendar.css' 
        );

        wp_enqueue_style( 
            'carsharing-public', 
            plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/public/css/style.css' 
        );
    }

    public function enqueue_scripts()
    {
        if ( ! is_singular( 'car' ) ) return;

        wp_deregister_script( 'jquery' );
        wp_enqueue_script( 
            'jquery', 
            'https://code.jquery.com/jquery-3.7.0.min.js',
            [],
            false, 
            true
        );

        wp_enqueue_script( 
            'fancybox', 
            'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js',
            [],
            false, 
            true
        );

        wp_enqueue_script( 
            'calendar', 
            plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/admin/js/calendar.js',
            [ 'jquery', ],
            false, 
            true
        );

        wp_enqueue_script( 
            'carsharing-public', 
            plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/public/js/script.js',
            [ 'jquery', 'fancybox', 'calendar', ],
            false, 
            true
        );
        $jsData[ 'ajax_url'] = admin_url( 'admin-ajax.php' );
        if ( is_singular( 'car' ) ) {
            $jsData[ 'car_id' ] = get_the_ID();
        }
        wp_localize_script(
            'carsharing-public',
            'carsharing',
            $jsData
        );
    }
}