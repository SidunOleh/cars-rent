<?php

defined( 'ABSPATH' ) or die;

abstract class Carsharing_Post_Type
{
    public function register()
    {
        register_post_type( $this->name(), [
            'label'  => $this->label(),
            'labels' => [
                'name'               => $this->label_plular(),
                'singular_name'      => $this->label(),
                'add_new'            => __( 'Add ' ) . $this->label(),
                'add_new_item'       => __( 'Add ' ) . $this->label(),
                'edit_item'          => __( 'Edit ' ) . $this->label(),
                'new_item'           => __( 'New ' ) . $this->label(),
                'view_item'          => __( 'View ' ) . $this->label(),
                'search_items'       => __( 'Search ' ) . $this->label(),
                'not_found'          => __( 'Not Found' ),
                'not_found_in_trash' => __( 'Not Found in Trash' ),
                'menu_name'          => $this->label_plular(),
            ],
            'public'              => $this->public(),
            'menu_position'       => $this->menu_position(),
            'menu_icon'           => $this->menu_icon(),
            'hierarchical'        => $this->hierarchical(),
            'supports'            => $this->supports(),
            'taxonomies'          => $this->taxonomies(),
            'has_archive'         => $this->has_archive(),
        ] );
    }

    protected function public(): bool
    {
        return true;
    }

    protected function menu_position(): int
    {
        return 20;
    }

    protected function menu_icon(): string
    {
        return 'dashicons-menu';
    }

    protected function hierarchical(): bool
    {
        return false;
    }

    protected function supports(): array
    {
        return [ 'title', 'editor', 'thumbnail', ];
    }

    protected function taxonomies(): array
    {
        return [];
    }

    protected function has_archive(): bool
    {
        return true;
    }

    protected abstract function name(): string;

    protected abstract function label(): string;

    protected abstract function label_plular(): string;
}