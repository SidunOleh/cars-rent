<?php

defined( 'ABSPATH' ) or die;

require_once CARSHARING_ROOT . '/includes/models/carsharing-model.php';
require_once CARSHARING_ROOT . '/includes/models/carsharing-price.php';
require_once CARSHARING_ROOT . '/includes/exceptions/carsharing-validation-exception.php';
require_once CARSHARING_ROOT . '/includes/services/facedetector/FaceDetector.php';
require_once CARSHARING_ROOT . '/includes/services/carsharing-cache-service.php';

class Carsharing_Order extends Carsharing_Model
{
    private $price_model;

    private $cache;

    public function __construct()
    {
        parent::__construct();
        $this->price_model = new Carsharing_Price;
        $this->cache = new Carsharing_Cache_Service;
    }

    public function get_by_id( $order_id )
    {
        $order = $this->db->get_row(
            "SELECT * 
            FROM `{$this->db->base_prefix}carsharing_orders` 
            WHERE `id` = {$order_id}"
        );

        return $order;
    }

    public function get_by_stripe_session_id( $session_id )
    {
        $order = $this->db->get_row(
            "SELECT * 
            FROM `{$this->db->base_prefix}carsharing_orders` 
            WHERE `stripe_session_id` = '{$session_id}'"
        );

        return $order;
    }

    public function get_by_date( DateTimeImmutable $date, $car_id ): array
    {
        $date = $date->format( 'Y-m-d' );

        $orders = $this->db->get_results(
            "SELECT * 
            FROM `{$this->db->base_prefix}carsharing_orders`
            WHERE `car_id` = {$car_id}  
            AND '{$date}' BETWEEN DATE(`start`) AND DATE(`end`)
            ORDER BY `start`"
        );

        return $orders ?? [];
    }

    public function latest( $page = 1, $per_page = 6 ): array
    {
        $offset = ( $page - 1 ) * $per_page;
        $orders = $this->db->get_results(
            "SELECT *, 
            (SELECT `post_title` 
                FROM `{$this->db->base_prefix}posts` AS `posts`
                WHERE `posts`.`ID` = `orders`.`car_id`) AS `car` 
            FROM `{$this->db->base_prefix}carsharing_orders` AS `orders`
            ORDER BY `created_at` DESC
            LIMIT {$per_page}
            OFFSET {$offset}"
        );

        return $orders ?? [];
    }

    public function update( array $data, array $where )
    {
        $result = $this->db->update(
            "{$this->db->base_prefix}carsharing_orders",
            $data,
            $where
        );

        return $result;
    }

    public function change_pay_status( $order_id )
    {
        $result = $this->db->query( 
            "UPDATE `{$this->db->base_prefix}carsharing_orders`
            SET `payed` = IF(`payed`, 0, 1)
            WHERE `id` = {$order_id}"
        );

        return $result;
    }

    public function delete( $order_id )
    {
        $result = $this->db->delete( 
            "{$this->db->base_prefix}carsharing_orders",
            [ 'id' => $order_id, ]
         );

        return $result;
    }

    public function create( array $data )
    {
        $validated = $this->validate_order_data( $data );
        $validated[ 'created_at' ] 
            = datetime()->format( 'Y-m-d H:i:s' );

        $result = $this->db->insert(
            "{$this->db->base_prefix}carsharing_orders",
            $validated
        );
        if ( ! $result ) {
            return false;
        }

        return $this->get_by_id( $this->db->insert_id );
    }

    private function validate_order_data( array $data ): array
    {
        $errors = [];

        $start = datetime( $data[ 'date' ] . ' ' . $data[ 'hour' ] );
        $end = $start->modify( '+' . format_rent_time( $data[ 'time' ] ) );

        if ( ! $this->is_valid_car( $data[ 'car_id' ] ) ) { // if car doesn't exist
            $errors[] = __( 'Car doesn\'t exist.' );
        }

        if ( $start < datetime() ) { // if time has passed
            $errors[] = __( 'Time has passed.' );
        }
        
        if ( ! $this->is_valid_hour( $data[ 'hour' ] ) ) { // if hour isn't allowed
            $errors[] = __( 'Hour isn\'t allowed.' );
        }
        
        if ( ! $this->is_valid_time( $data[ 'time' ] ) ) { // if time isn't allowed
            $errors[] = __( 'Time interval isn\'t allowed.' );
        }

        if ( 
            ! $price = $this->price_model->get_for_order( 
                $data[ 'car_id' ], 
                datetime( $data[ 'date' ] ), 
                $data[ 'time' ],
            )
        ) { // if hasn't price for time
            $errors[] = __( 'No price for time interval.' );
        }

        if ( 
            $this->is_day_off( $start, $data[ 'car_id' ] ) or
            $this->is_day_off( $end, $data[ 'car_id' ] )
        ) { // if days off
            $errors[] = __( 'Can\'t rent in day off.' );
        }

        if ( ! $this->is_hours_workly( $start, $end ) ) { // if time is out of working hours
            $errors[] = __( 'Time is out of working hours.' );
        }

        if ( ! $this->is_free_slot( $start, $end, $data[ 'car_id' ] ) ) { // if time is reserved
            $errors[] = __( 'Time is reserved.' );
        }

        if ( ! is_string( $data[ 'client_name' ] ) ) { // if client name is invalid
            $errors[] = __( 'Invalid name.' );
        }
        
        if ( ! is_string( $data[ 'client_phone' ] ) ) { // if client phone is invalid
            $errors[] = __( 'Invalid phone.' );
        }

        if ( ! is_email( $data[ 'client_email' ] ) ) { // if client email is invalid
            $errors[] = __( 'Invalid email.' );
        }

        if ( ! file_exists( $data[ 'client_photo' ][ 'tmp_name' ] ) ) { // if client photo isn't passed
            $errors[] = __(  'Photo is required.' );
        }

        if ( $data[ 'client_photo' ][ 'type' ] != 'image/jpeg' ) { // if client photo isn't in jpeg format
            $errors[] = __(  'Photo has to be in jpeg format.' );
        }

        if ( 
            $data[ 'client_photo' ][ 'type' ] == 'image/jpeg' and 
            ! $this->has_photo_face( $data[ 'client_photo' ][ 'tmp_name' ] ) 
        ) { // if client photo hasn't face
            $errors[] = __(  'No face was found.' );
        }

        if ( count( $errors ) > 0 ) throw new Carsharing_Validation_Exception( $errors );
        
        $validated = [
            'car_id' => $data[ 'car_id' ],
            'start' => 
                $start->format( 'Y-m-d H:i' ),
            'end' => 
                $end->format( 'Y-m-d H:i' ),
            'client_name' => 
                $data[ 'client_name' ],
            'client_phone' => 
                $data[ 'client_phone' ],
            'client_email' => 
                $data[ 'client_email' ],
            'client_photo' => 
                $this->save_file( 
                    $data[ 'client_photo' ], 
                    '/includes/storage/img/clients' 
                ),
            'price' => $price,
        ];
        
        // options fields
        if ( isset( $data[ 'comment' ] ) and is_string( $data[ 'comment' ] ) ) {
            $validated[ 'comment' ] = $data[ 'comment' ];
        }

        if ( isset( $data[ 'options' ] ) and is_array( $data[ 'options' ] ) ) {
            $validated[ 'options' ] 
                = json_encode( $data[ 'options' ] );
            $validated[ 'price' ] 
                += $this->get_options_price( $data[ 'options' ], $data[ 'car_id' ] );
        }

        return $validated;
    }

    public function is_valid_car( $car_id ): bool
    {
        return ( bool ) get_posts( [ 
            'post_type' => 'car', 
            'include' => [ $car_id, ] 
        ] );
    }

    public function is_valid_hour( string $hour ): bool
    {
        $hours = explode( ',', get_carsharing_option( 'rent_hours' ) );
        if ( ! in_array( $hour, $hours ) ) {
            return false;
        }

        return true;
    }

    public function is_valid_time( string $time ): bool
    {
        $times = explode( ',', get_carsharing_option( 'rent_times' ) );
        if ( ! in_array( $time, $times ) ) {
            return false;
        }

        return true;
    }

    public function is_hours_workly( DateTimeImmutable $start, DateTimeImmutable $end ): bool
    {
        $start_hour = get_carsharing_option( 'start_hour' );
        $end_hour = get_carsharing_option( 'end_hour' );
        if (
            ( $start->format( 'H:i' ) < $start_hour or $start->format( 'H:i' ) > $end_hour ) or
            ( $end->format( 'H:i' ) < $start_hour or $end->format( 'H:i' ) > $end_hour )
        ) {
            return false;
        }

        return true;
    }

    public function has_photo_face( string $photo ): bool
    {
        $result = ( new \svay\FaceDetector(
            CARSHARING_ROOT . '/includes/services/facedetector/detection.dat'
        ) )->faceDetect( $photo );
        
        return $result;
    }

    public function get_options_price( array $options, $car_id ): int
    {
        $price = 0;

        $all_options = carbon_get_post_meta( $car_id, 'rent_options' );
        foreach ( $options as $name => $value ) {
            foreach ( $all_options as $all_option ) {
                if ( $all_option[ 'title' ] == $name ) {
                    foreach ( $all_option[ 'option' ] as $item ) {
                        if ( $item[ 'item' ] == $value ) {
                            $price += $item[ 'price' ];
                        }
                    }
                }
            }
        }

        return $price;
    }

    public function get_slots( DateTimeImmutable $start, $car_id ): array
    {
        $rent_times = explode( ',', get_carsharing_option( 'rent_times' ) );
        $slots = [];
        foreach ( $rent_times as $rent_time ) {
            $slot[ 'time' ] = $rent_time;
            $slot[ 'start' ] = $start;
            $slot[ 'end' ] = 
                $slot[ 'start' ]->modify( '+' . format_rent_time( $rent_time ) );
            $slot[ 'price' ] = 
                $this->price_model->get_for_order( $car_id, $slot[ 'start' ], $slot[ 'time' ] );
            // if slot isn't in work hours
            if ( ! $this->is_hours_workly( $slot[ 'start' ], $slot[ 'end' ] ) ) {
                $slot[ 'is_free' ] = false;
            } else {
                $slot[ 'is_free' ] = 
                    $this->is_free_slot( $slot[ 'start' ], $slot[ 'end' ], $car_id );
            }
            $slots[] = $slot;
        }

        return $slots;
    }

    private function is_free_slot( DateTimeImmutable $start, DateTimeImmutable $end, $car_id ): bool
    {
        if ( $start < datetime() ) { // if time passed
            return false;
        }
        
        if ( 
            $this->is_day_off( $start, $car_id ) or
            $this->is_day_off( $end, $car_id )
        ) { // if days off
            return false;
        }

        // start/end with between time
        $time_between = 
            get_carsharing_option( 'time_between_rents' ) ?? 59;
        $start = $start->modify( "-{$time_between} minutes" )
            ->format( 'Y-m-d H:i' );
        $end = $end->modify( "+{$time_between} minutes" )
            ->format( 'Y-m-d H:i' );

        $sql = "SELECT *  FROM `{$this->db->base_prefix}carsharing_orders`
            WHERE `car_id` = {$car_id} AND (
                (
                    `start` BETWEEN '{$start}' AND '{$end}' AND 
                    `end` BETWEEN '{$start}'AND '{$end}'
                ) OR (
                    '{$start}' BETWEEN `start` AND `end` OR
                    '{$end}' BETWEEN `start` AND `end`
                )
            )";
  
        return ! $this->db->get_row( $sql );
    }

    public function get_days( int $year, int $month, $car_id ): array
    {
        $days_count = cal_days_in_month( CAL_GREGORIAN, $month, $year );
        $days = [];
        for ( $i = 1; $i <= $days_count; $i++ ) { 
            $day[ 'day' ] = 
                datetime( "{$year}-{$month}-{$i}" ); 
            $day[ 'is_free' ] = 
                $this->is_free_day( $day[ 'day' ], $car_id );
            $days[] = $day;
        }

        return $days;
    }

    private function is_free_day( DateTimeImmutable $day, $car_id ): bool
    {
        // if day passed
        if ( $day->format( 'Y-m-d' ) < datetime()->format( 'Y-m-d' ) ) {
            return false;
        }

        // if day off
        if ( $this->is_day_off( $day, $car_id ) ) {
            return false;
        }

        // if day has free slot
        $rent_times = explode( ',', get_carsharing_option( 'rent_times' ) );
        foreach ( $rent_times as $rent_time ) {
            $rent_hours = explode( ',', get_carsharing_option( 'rent_hours' ) );
            foreach ( $rent_hours as $rent_hour ) {
                $start = $day->modify( '+' . ltrim( explode( ':', $rent_hour )[0], '0' ) . ' hours' );
                $end = $start->modify( '+' . format_rent_time( $rent_time ) );

                if ( ! $this->is_hours_workly( $start, $end ) ) {
                    continue;
                }
                if ( $this->is_free_slot( $start, $end, $car_id ) ) {
                    return true;
                }
            }
        }

        return false;
    }

    public function total(): int
    {
        $result = $this->db->get_row( 
            "SELECT COUNT(*) AS total_count 
            FROM `{$this->db->base_prefix}carsharing_orders`"
        );

        return $result->total_count;
    }

    public function statistic( int|null $year = null, int|null $month = null )
    {
        if ( $cached = $this->cache->get( "statistic|{$year}|{$month}" ) ) {
            return $cached;
        }

        $year_cond = $year ? "YEAR(`orders`.`start`) = {$year}" : 1;
        $month_cond = $month ? "MONTH(`orders`.`start`) = {$month}" : 1;

        $result = $this->db->get_results(
            "WITH `cars` 
            AS (
                SELECT * 
                FROM `{$this->db->base_prefix}posts` 
                WHERE `post_type` = 'car'
                AND `post_status` = 'publish'
            )
            
            SELECT 
                `cars`.`post_title`,
                ( SELECT COUNT(*)
                    FROM `{$this->db->base_prefix}carsharing_orders` AS `orders`
                    WHERE `orders`.`car_id` = `cars`.`ID` 
                    AND {$year_cond} 
                    AND {$month_cond} 
                ) AS `orders_count`,
                ( SELECT SUM(`orders`.`price`)
                    FROM `{$this->db->base_prefix}carsharing_orders` AS `orders`
                    WHERE `orders`.`car_id` = `cars`.`ID`
                    AND {$year_cond} 
                    AND {$month_cond} 
                ) AS `orders_amount`
            FROM `cars`"
        );

        $this->cache->set( 
            "statistic|{$year}|{$month}", 
            $result, 
            HOUR_IN_SECONDS 
        );

        return $result;
    }

    public function change_day_off( DateTimeImmutable $date, $car_id )
    {
        if ( $this->is_day_off( $date, $car_id ) ) {
            $result = $this->db->delete(
                "{$this->db->base_prefix}carsharing_days_off",
                [
                    'date' => $date->format( 'Y-m-d' ),
                    'car_id' => $car_id,
                ]
            );
        } else {
            $result =  $this->db->insert(
                "{$this->db->base_prefix}carsharing_days_off",
                [
                    'date' => $date->format( 'Y-m-d' ),
                    'car_id' => $car_id,
                ]
            );
        }

        return $result;
    }

    public function is_day_off( DateTimeImmutable $date, $car_id ): bool
    {
        $date = $date->format( 'Y-m-d' );

        $result = $this->db->get_row( 
            "SELECT * 
            FROM `{$this->db->base_prefix}carsharing_days_off`
            WHERE `date` = '{$date}' 
            AND `car_id` = {$car_id}"
        );

        return ( bool ) $result;
    }
}