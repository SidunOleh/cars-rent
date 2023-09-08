<div id="add-order-popup" style="display: none;">

    <form 
        action="<?php echo admin_url( 'admin-ajax.php' ) ?>" 
        method="POST"
        class="form" 
        id="add-order-form">

        <input type="hidden" name="action" value="create_order_admin" id="add-order-action">

        <div class="field">
            <label for="car-name"><?php _e( 'Car' ) ?>:</label>
            <select name="car_id" id="car-id">
            
                <?php 
                $cars = get_cars();
                foreach ( $cars as $i => $car ) : ?>

                <option value="<?php echo $car->ID ?>">
                    <?php echo $car->post_title ?>
                </option>
                
                <?php endforeach ?>

            </select>
        </div>

        <div class="field">
            <label for="date"><?php _e( 'Date' ) ?>:</label>
            <input 
                type="date" 
                name="date" 
                id="date"
                required>
        </div>

        <div class="field">
            <label for="hour"><?php _e( 'Hour' ) ?>:</label>
            <input 
                type="time" 
                name="hour" 
                id="hour"
                required
                list="hours">
        </div>

        <datalist id="hours">
            <?php 
            $hours = explode( ',', get_carsharing_option( 'rent_hours' ) );
            foreach ( $hours as $hour ) :
            ?>
            <option value="<?php echo $hour ?>">
                <?php echo $hour ?>
            </option>
            <?php endforeach ?>
        </datalist>

        <div class="field">
            <label for="time"><?php _e( 'Time' ) ?>:</label>
            <select 
                name="time" 
                id="time"
                required>

                <?php
                $times = explode( ',', get_carsharing_option( 'rent_times' ) );
                foreach ( $times as $time ) :
                ?>
                <option value="<?php echo $time ?>">
                    <?php echo format_rent_time( $time ) ?>
                </option>
                <?php endforeach ?>
            
            </select>
        </div>

        <div class="field">
            <label for="client-name"><?php _e( 'Name' ) ?>:</label>
            <input type="text" name="client_name" id="client-name" required>
        </div>

        <div class="field">
            <label for="client-phone"><?php _e( 'Phone' ) ?>:</label>
            <input type="text" name="client_phone" id="client-phone" required>
        </div>

        <div class="field">
            <label for="client-email"><?php _e( 'E-mail' ) ?>:</label>
            <input type="email" name="client_email" id="client-email" required>
        </div>

        <div class="field">
            <label for="client-photo"><?php _e( 'Photo' ) ?>:</label>
            <input type="file" name="client_photo" id="client-photo" required accept="image/jpeg">
        </div>

        <button 
            type="submit" 
            class="button button-primary">
            <?php _e( 'Add' ) ?>
        </button>

    </form>
    
</div>