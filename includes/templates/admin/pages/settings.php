<div class="settings">

    <div class="settings__body">

        <?php $settings = get_option( 'carsharing_settings' ) ?>

        <form 
            action="<?php echo admin_url( 'admin-ajax.php' ) ?>" 
            method="POST"
            id="carsharing-settings-form">

            <input type="hidden" name="action" value="save_settings_admin">

            <div class="settings__group">

                <div class="settings__title accordion__title">
                    <?php _e( 'Rent' ) ?>
                </div>

                <div class="settings__content accordion__content show">

                    <div class="settings__row">

                        <div class="setting">
                            <label for="start-time">
                                <?php _e( 'Work start hour' ) ?>
                            </label>
                            <input 
                                id="start-time"
                                type="time" 
                                name="settings[start_hour]"
                                value="<?php echo $settings[ 'start_hour' ] ?? '' ?>">
                        </div>

                        <div class="setting">
                            <label for="end-hour">
                                <?php _e( 'Work end hour' ) ?>
                            </label>
                            <input 
                                id="end-hour"
                                type="time"
                                name="settings[end_hour]"
                                value="<?php echo $settings[ 'end_hour' ] ?? '' ?>">
                        </div>
                        
                    </div>

                    <div class="setting">
                        <label for="rent-hours">
                            <?php _e( 'Rent hours(24 hour format)' ) ?>
                        </label>
                        <input 
                            id="rent-hours"
                            autocomplete="off"
                            type="text" 
                            name="settings[rent_hours]"
                            value="<?php echo $settings[ 'rent_hours' ] ?? '' ?>">
                    </div>

                    <div class="setting">
                        <label for="rent-times">
                            <?php _e( 'Rent times' ) ?>
                            <br>
                            h - <?php _e( 'hour' ) ?>
                            <br>
                            d - <?php _e( 'day' ) ?>
                        </label>

                        <input 
                            id="rent-times"
                            autocomplete="off"
                            type="text" 
                            name="settings[rent_times]"
                            value="<?php echo $settings[ 'rent_times' ] ?? '' ?>">
                    </div>

                    <div class="setting">
                        <label for="time-between-rents">
                            <?php _e( 'Time between rents(in minutes)' ) ?>
                        </label>
                        <input 
                            id="time-between-rents"
                            type="number" 
                            min="0"
                            name="settings[time_between_rents]"
                            value="<?php echo $settings[ 'time_between_rents' ] ?? '' ?>">
                    </div>
                
                </div>

            </div>

            <div class="settings__group">

                <div class="settings__title accordion__title">
                    <?php _e( 'Contacts' ) ?>
                </div>

                <div class="settings__content accordion__content show">

                    <div class="setting">
                        <label for="notification-email">
                            <?php _e( 'E-mail' ) ?>
                        </label>
                        <input 
                            id="notification-email"
                            type="email" 
                            name="settings[notification_email]"
                            value="<?php echo $settings[ 'notification_email' ] ?? '' ?>">
                    </div>

                    <div class="setting">
                        <label for="notification-email">
                            <?php _e( 'Phone' ) ?>
                        </label>
                        <input 
                            id="phone"
                            type="text" 
                            name="settings[phone]"
                            value="<?php echo $settings[ 'phone' ] ?? '' ?>">
                    </div>

                </div>

            </div>

            <div class="settings__group">

                <div class="settings__title accordion__title">
                    <?php _e( 'Stripe' ) ?>
                </div>

                <div class="settings__content accordion__content show">

                    <div class="setting">
                        <label for="stripe-key">
                            <?php _e( 'Stripe key' ) ?>
                        </label>
                        <input 
                            id="stripe-key"
                            autocomplete="off"
                            type="text" 
                            name="settings[stripe_key]"
                            value="<?php echo $settings[ 'stripe_key' ] ?? '' ?>">
                    </div>

                    <div class="setting">
                        <label for="stripe-secret">
                            <?php _e( 'Stripe secret' ) ?>
                        </label>
                        <input 
                            id="stripe-secret"
                            autocomplete="off"
                            type="text" 
                            name="settings[stripe_secret]"
                            value="<?php echo $settings[ 'stripe_secret' ] ?? '' ?>">
                    </div>

                </div>

            </div>

            <div class="settings__btn">
                <button type="submit">
                    <?php _e( 'Save' ) ?>
                </button>
            </div>

        </form>

    </div>

</div>