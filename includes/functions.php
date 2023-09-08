<?php

defined( 'ABSPATH' ) or die;

/**
 * Read template
 */
function template_read( $template_path, $data = [] ): string {
    extract( $data );

    ob_start();
    require $template_path;
    $template_data = ob_get_clean();

    return $template_data;
}

/**
 * Get DateTime
 */
function datetime( $time = 'now', $timezone = 'America/New_York' ): DateTimeImmutable {
    $timezone = new DateTimeZone( $timezone );
    $datetime = new DateTimeImmutable( $time, $timezone );

    return $datetime;
}

/**
 * Get carsharing option
 */
function get_carsharing_option( $name ) {
    $settings = get_option( 'carsharing_settings' );

    return $settings[ $name ] ?? null;
}

/**
 * Pagination
 */
function pagination( int $current_page, int $total_count, int $per_page ): string {
    if ( $total_count <= $per_page ) return '';

    $last_page = ceil( $total_count / $per_page );
    $pagination = '
        <div class="pag">
            <span data-page-number="' . $current_page - 1 . '" class="pag__arrow prev ' . ( $current_page == 1 ? 'disable' : '' ) . '">
                ←
            </span>
            <span data-page-number="' . $current_page + 1 . '" class="pag__arrow next ' . ( $current_page == $last_page ? 'disable' : '' ) . '">
                →
            </span>
        </div>
    ';

    return $pagination;
}

/**
 * Get month name
 */
function get_month_name( $i ) {
    return [
        __( 'January' ), __( 'February' ), __( 'March' ),
        __( 'April' ), __( 'May' ), __( 'June' ),
        __( 'July' ), __( 'August' ), __( 'September' ),
        __( 'October' ), __( 'November' ), __( 'December' )
    ][ $i ];
}

/**
 * Register ajax callback
 */
function ajax_callback( 
    string $action, 
    callable $callback, 
    bool $nopriv = false 
) {
    add_action( "wp_ajax_{$action}", $callback );

    if ( $nopriv ) {
        add_action( "wp_ajax_nopriv_{$action}", $callback ); 
    }
}

/**
 * Get cars
 */
function get_cars() {
    return get_posts( [ 
        'post_type' => 'car', 
        'numberposts' => -1, 
        'orderby' => 'date',
    ] );
}

/**
 * Format rent time
 */
function format_rent_time( $time ) {
    return preg_replace_callback( '/^([0-9]+)(h|d)$/', function ( $matches ) {
        switch ( $matches[2] ) {
            case 'h':
                return $matches[1] . ' ' . ( $matches[1] == 1 ? __( 'hour' ) : __( 'hours' ) );
            case 'd':
                return $matches[1] . ' ' . ( $matches[1] == 1 ? __( 'day' ) : __( 'days' ) );
        }
    }, $time );
}