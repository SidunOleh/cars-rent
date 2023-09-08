<div class="hours">

    <div class="hours-option">
        <?php 
        $has_one_free = false; 
        foreach ( $slots as $slot ): 
        if ( $slot[ 'is_free' ] ) $has_one_free = true; 
        if ( ! $slot[ 'price' ] ) continue;
        ?>
        <p class="<?php echo $slot[ 'is_free' ] ? '' : 'disabled' ?>">
            <input 
                type="radio" 
                id="time-<?php echo $slot[ 'time' ] ?>"
                value="<?php echo $slot[ 'time' ] ?>" 
                data-time="<?php echo format_rent_time( $slot[ 'time' ] ) ?>"
                data-price="<?php echo $slot[ 'price' ] ?>"
                name="time"
                class="time-radiobtn"
                form="rent-form"
                <?php echo $slot[ 'is_free' ] ? '' : 'disabled' ?>/>

            <label for="time-<?php echo $slot[ 'time' ] ?>">
                <?php echo format_rent_time( $slot[ 'time' ] ) ?> <?php _e( 'rental' ) ?> 

                <span class="price">
                    $<?php echo $slot[ 'price' ] ?>
                </span>
            </label>
        </p>
        <?php endforeach ?>
    </div>

    <?php if ( ! $has_one_free ):  ?>
    <div class="allert">
        <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' )  ?>/includes/assets/public/img/info.svg" alt="" />
        
        <p class="text">
            <?php _e( 'There are no free hours. <br />Please choose another number of rental hours.' ) ?>
        </p>
    </div>
    <?php endif ?>

</div>