<div class="pricing__prices">

    <form 
        action="<?php echo admin_url( 'admin-ajax.php' ) ?>" 
        method="POST" 
        id="save-prices-form">

        <input type="hidden" name="action" value="save_prices_admin">

        <div class="pricing__date">
        
            <div class="pricing__title accordion__title">
                <?php _e( 'Prices for' ) ?> <span id="price-date"></span>
            </div>
        
            <div class="prices accordion__content show">
        
                <?php
                
                    $rent_times = explode( ',', get_carsharing_option( 'rent_times' ) );
                    foreach ( $rent_times as $rent_time ): if ( ! $rent_time ) continue;
                ?>
        
                <div class="pricing__price">
                    <label for="date-prices-<?php echo $rent_time ?>">
                        <?php echo format_rent_time( $rent_time ) ?>
                    </label>
                    <div class="value">
                        $ <input 
                            type="number" 
                            name="date_prices[<?php echo $rent_time ?>]" 
                            id="date-prices-<?php echo $rent_time ?>"
                            value="<?php echo isset( $date_prices[$rent_time] ) ? $date_prices[$rent_time] : '' ?>">
                    </div>
                </div>
        
                <?php endforeach ?>
        
            </div>
        
        </div>
        
        <div class="pricing__default">

            <div class="pricing__title accordion__title">
                <?php _e( 'Default prices' ) ?>
            </div>

            <div class="prices accordion__content">

                <?php
                    $rent_times = explode( ',', get_carsharing_option( 'rent_times' ) );
                    foreach ( $rent_times as $rent_time ): if ( ! $rent_time ) continue;
                ?>

                <div class="pricing__price">
                    <label for="default-prices-<?php echo $rent_time ?>">
                        <?php echo format_rent_time( $rent_time ) ?>
                    </label>
                    <div class="value">
                        $ <input 
                            type="number" 
                            name="default_prices[<?php echo $rent_time ?>]" 
                            id="default-prices-<?php echo $rent_time ?>"
                            value="<?php echo isset( $default_prices[$rent_time] ) ? $default_prices[$rent_time] : '' ?>">
                    </div>
                </div>

                <?php endforeach ?>

            </div>

        </div>

        <div class="pricing__btn">
            <button type="submit">
                <?php _e( 'Save' ) ?>
            </button>
        </div>

    </form>

</div>