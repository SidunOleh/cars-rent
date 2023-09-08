<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php _e( 'New Order' ) ?></title>
</head>
<body>
    <div class="email">

        <h1 class="email__title">
            <?php _e( 'New order' ) ?>
        </h1>
        
        <div class="email__txt">
            <b><?php _e( 'Car' ) ?>:<b> <?php echo get_the_title( $order->car_id ) ?>
            <br>
            <b><?php _e( 'From' ) ?></b> 
            <?php echo datetime( $order->start )->format( 'm/d/Y h:i A' ) ?>
            <b><?php _e( 'To' ) ?></b> 
            <?php echo datetime( $order->end )->format( 'm/d/Y h:i A' ) ?>
        </div>

    </div>
</body>
</html>