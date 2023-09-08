<div class="latest-order order-item" data-id="<?php echo $order->id ?>">

    <div class="latest-order__left">
        
        <div class="latest-order__img">
            
            <a href="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . $order->client_photo ?>" data-fancybox>
               
                <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . $order->client_photo ?>">
            
            </a>

        </div>

    </div>

    <div class="latest-order__right">

        <div class="latest-order__date start">
            <span><?php _e( 'Rent start' ) ?>:</span>  
            <?php echo ( datetime( $order->start ) )->format( 'M d, Y H:i' ) ?>
        </div>

        <div class="latest-order__date end">
            <span><?php _e( 'Rent end' ) ?>:</span> 
            <?php echo ( datetime( $order->end ) )->format( 'M d, Y H:i' ) ?>
        </div>

        <div class="latest-order__car">
            <span><?php _e( 'Car' ) ?>:</span> 
            <?php echo $order->car ?>
        </div>

        <div class="latest-order__name">
            <span><?php _e( 'Client name' ) ?>:</span>
            <?php esc_html_e( $order->client_name ) ?>
        </div>

        <div class="latest-order__phone">
            <span><?php _e( 'Client phone' ) ?>:</span>
            <?php esc_html_e( $order->client_phone ) ?>
        </div>

        <div class="latest-order__email">
            <span><?php _e( 'Client e-mail' ) ?>:</span>
            <?php echo $order->client_email ?>
        </div>

        <div class="latest-order__created">
            <span><?php _e( 'Ordered' ) ?>:</span>
            <?php echo datetime( $order->created_at )->format( 'M d, H:i' ) ?>
        </div>

        <div class="latest-order__payed">
            <span><?php _e( 'Pay status' ) ?>:</span> 

            <label class="toggle" title="Chage pay status">
                <input 
                    class="toggle-checkbox" 
                    type="checkbox" 
                    <?php echo $order->payed ? 'checked' : '' ?>
                    id="payed">
                <div class="toggle-switch"></div>
            </label>
            
            <span class="order__price">$<?php echo $order->price ?></span>
        </div>

        <div class="latest-order__expand">

            <?php if ( $order->comment ): ?>
            <div class="latest-order__comment">
                <span><?php _e( 'Comment' ) ?>:</span>
                <?php esc_html_e( $order->comment ) ?>
            </div>
            <?php endif ?>

            <?php if ( $order->options ): ?>
            <div class="latest-order__options">
                <span><?php _e( 'Options' ) ?>:</span>
                <?php esc_html_e( implode( ', ', json_decode( $order->options, true ) ) ) ?>
            </div>
            <?php endif ?>

        </div>

    </div>

    <div class="latest-order__close close-order" title="Delete">
        <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/admin/img/delete.png' ?>" alt="">
    </div>

</div>