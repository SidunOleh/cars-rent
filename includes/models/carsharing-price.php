<?php

defined( 'ABSPATH' ) or die;

require_once CARSHARING_ROOT . '/includes/models/carsharing-model.php';

class Carsharing_Price extends Carsharing_Model
{
    public function get( $car_id, DateTimeImmutable|null $date = null ): array
    {
        $prices = $this->db->get_row(
            "SELECT * 
            FROM `{$this->db->base_prefix}carsharing_prices` 
            WHERE `car_id` = {$car_id}
            AND `date` " . ( $date == null ? "IS NULL" : "= '" . $date->format( 'Y-m-d' ) . "'" ) 
        );

        if ( ! $prices ) return [];

        return array_filter( 
            json_decode( $prices->prices, true ), 
            fn( $time ) => in_array( $time, explode( ',', get_carsharing_option( 'rent_times' ) ) ), 
            ARRAY_FILTER_USE_KEY 
        );
    }

    public function get_for_order( $car_id, DateTimeImmutable $date, string $time ): int|null
    {
        if ( ! in_array( $time, explode( ',', get_carsharing_option( 'rent_times' ) ) ) ) 
            return false;

        $specific_prices = $this->get( $car_id, $date );
        foreach ( $specific_prices as $duration => $price ) {
            if ( empty( $price ) ) continue;

            if ( $duration == $time ) {
                return $price;
            }
        }

        $default_prices = $this->get( $car_id );
        foreach ( $default_prices as $duration => $price ) {
            if ( empty( $price ) ) continue;

            if ( $duration == $time ) {
                return $price;
            }
        }

        return null;
    }

    public function save( array $prices, $car_id, DateTimeImmutable|null $date = null )
    {       
        if ( $this->get( $car_id, $date ) ) {
            $result = $this->db->update(
                "{$this->db->base_prefix}carsharing_prices",
                [ 'prices' => json_encode( $prices ), ],
                [
                    'car_id' => $car_id,
                    'date' => $date ? $date->format( 'Y-m-d' ) : null,
                ]
            );
        } else {
            $result = $this->db->insert(
                "{$this->db->base_prefix}carsharing_prices",
                [
                    'car_id' => $car_id,
                    'date' => $date ? $date->format( 'Y-m-d' ) : null,
                    'prices' => json_encode( $prices ),
                ]
            );
        }

        return $result; 
    }
}