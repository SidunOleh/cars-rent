<div class="carsharing">

    <div class="carsharing__body">

        <div class="carsharing__orders">
    
            <div id="add-order" title="Add">
                +
            </div>

        </div>

        <div class="carsharing__sidebar">

            <div class="carsharing__calendar">
                <div id="carsharing-calendar">
                    <!-- calendar -->
                </div>
            </div>

            <div class="carsharing__cars">

                <?php 
                $cars = get_cars();
                foreach ( $cars as $i => $car ) : ?>
                    <div 
                        class="carsharing__car <?php echo $i == 0 ? 'selected' : '' ?>" 
                        data-car_id="<?php echo $car->ID ?>"><?php echo $car->post_title ?></div>
                <?php endforeach ?>

            </div>

            <div class="carsharing__off">

                <span><?php _e( 'Day off' ) ?></span> 

                <label class="toggle" title="<?php _e( 'Day off' ) ?>">
                    <input 
                        class="toggle-checkbox" 
                        type="checkbox" 
                        id="day-off">
                    <div class="toggle-switch"></div>
                </label>

            </div>

        </div>
        
    </div>

    <?php require_once CARSHARING_ROOT . '/includes/templates/admin/popups/add-order.php' ?>
    
</div>