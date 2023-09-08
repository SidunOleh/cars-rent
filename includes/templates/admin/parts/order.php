<div class="order order-item" data-id="<?php echo $order->id ?>">

    <div class="order__left">
        
        <div class="order__img">
            
            <a href="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . $order->client_photo ?>" data-fancybox>
               
                <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . $order->client_photo ?>">
            
            </a>

        </div>

    </div>

    <div class="order__right">

        <div class="order__date start">
            <span><?php _e( 'Rent start' ) ?>:</span>  
            <?php echo ( datetime( $order->start ) )->format( 'M d, H:i' ) ?>
        </div>

        <div class="order__date end">
            <span><?php _e( 'Rent end' ) ?>:</span> 
            <?php echo ( datetime( $order->end ) )->format( 'M d, H:i' ) ?>
        </div>

        <div class="order__name">
            <span><?php _e( 'Client name' ) ?>:</span>
            <?php esc_html_e( $order->client_name ) ?>
        </div>

        <div class="order__phone">
            <span><?php _e( 'Client phone' ) ?>:</span>
            <?php esc_html_e( $order->client_phone ) ?>
        </div>

        <div class="order__email">
            <span><?php _e( 'Client e-mail' ) ?>:</span>
            <?php echo $order->client_email ?>
        </div>

        <div class="order__created">
            <span><?php _e( 'Ordered' ) ?>:</span>
            <?php echo datetime( $order->created_at )->format( 'M d, H:i' ) ?>
        </div>

        <div class="order__payed">
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

        <div class="order__expand">

            <?php if ( $order->comment ): ?>
            <div class="order__comment">
                <span><?php _e( 'Comment' ) ?>:</span>
                <?php esc_html_e( $order->comment ) ?>
            </div>
            <?php endif ?>

            <?php if ( $order->options ): ?>
            <div class="order__options">
                <span><?php _e( 'Options' ) ?>:</span>
                <?php esc_html_e( implode( ', ', json_decode( $order->options, true ) ) ) ?>
            </div>
            <?php endif ?>

        </div>

    </div>

    <div class="order__close close-order" title="Delete">
        <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' ) . '/includes/assets/admin/img/delete.png' ?>" alt="">
    </div>

</div>