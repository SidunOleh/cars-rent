<div class="latest">

    <div class="latest__top">
        <div class="latest__count">
            <?php
            $start = ( $page - 1 ) * $per_page + 1;
            $end = $start + $per_page - 1;
            if ( $end > $orders_total_count ) $end = $orders_total_count;
            if ( $end == 0 ) $start = 0;
            ?>
            <?php printf( 
                'Showing <span>%d–%d</span> of <span>%d</span>', 
                $start, 
                $end, 
                $orders_total_count 
            ) ?>
        </div>
    </div>

    <div class="latest__body">
        
        <?php foreach ( $latest as $order ) : ?>

            <?php require CARSHARING_ROOT . '/includes/templates/admin/parts/latest-order.php' ?>
            
        <?php endforeach ?>

    </div>

    <?php echo pagination( $page, $orders_total_count, $per_page ) ?>

</div>