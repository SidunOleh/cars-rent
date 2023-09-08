<div class="carsharing__orders">
    
    <?php foreach ( $orders as $order ) : ?>

        <?php require CARSHARING_ROOT . '/includes/templates/admin/parts/order.php' ?>
        
    <?php endforeach ?>

    <div id="add-order" title="Add">
        +
    </div>

</div>