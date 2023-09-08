<div class="pricing">

       <div class="pricing__body">

            <?php require_once CARSHARING_ROOT . '/includes/templates/admin/parts/prices.php' ?>

            <div class="pricing__sidebar">

                <div class="pricing__calendar">
                    <div id="pricing-calendar">
                        <!-- calendar -->
                    </div>
                </div>  

                <div class="pricing__cars">

                    <?php 
                    $cars = get_cars();
                    foreach ( $cars as $i => $car ) : ?>
                        <div 
                            class="pricing__car <?php echo $i == 0 ? 'selected' : '' ?>" 
                            data-car_id="<?php echo $car->ID ?>"><?php echo $car->post_title ?></div>
                    <?php endforeach ?>

                </div>

            </div>

       </div>
    
</div>