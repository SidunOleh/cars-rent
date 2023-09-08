<div class="analytics__body">

    <div class="analytics__top">
        
        <select name="year" id="analytics-year" class="analytics__year">
            
            <option value="">
                <?php _e( 'All' ) ?>
            </option>

            <?php for ( $i = datetime()->format( 'Y' ) + 2; $i >= 2000; $i-- ): ?>
                <option 
                    value="<?php echo $i ?>" 
                    <?php echo $i == datetime()->format( 'Y' ) ? 'selected' : '' ?>>
                    <?php echo $i ?>
                </option>
            <?php endfor ?>
            
        </select>

        <select name="year" id="analytics-month" class="analytics__month">
            
            <option value="">
                <?php _e( 'All' ) ?>
            </option>
            
            <?php for ( $i = 0; $i < 12; $i++ ): ?>
                <option 
                    value="<?php echo $i + 1 ?>"
                    <?php echo ( $i + 1 ) == datetime()->format( 'n' ) ? 'selected' : '' ?>> 
                    <?php echo get_month_name( $i ) ?>
                </option>
            <?php endfor ?>

        </select>

    </div>
    
    <div class="analytics__charts">

        <div class="analytics__chart">
            <canvas id="orders-count-charts">
            </canvas>
        </div>

        <div class="analytics__chart">
            <canvas id="orders-amount-charts">
            </canvas>
        </div>

    </div>

</div>