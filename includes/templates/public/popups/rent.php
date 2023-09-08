<div class="rent-wrapper hidden">
    <div class="next-step-popup">
        
        <div class="close">
            <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' )  ?>/includes/assets/public/img/close.svg" alt="" />
        </div>
        
        <div class="banner">
            <img src="<?php echo wp_get_attachment_image_url( carbon_get_the_post_meta( 'first_bg' ), 'full' ) ?>" alt="" />
        </div>
        
        <div class="card">

            <p class="section-title">
                <?php echo carbon_get_the_post_meta( 'first_title' ) ?>
            </p>
            
            <p class="text">
                <?php echo carbon_get_the_post_meta( 'first_text' ) ?>
            </p>

            <div class="hour selected-time"></div>
            
            <div class="charact-list">
                <?php
                $props = carbon_get_the_post_meta( 'prop_items' );
                foreach ( $props as $prop ):
                ?>
                <p class="text">
                    <img src="<?php echo wp_get_attachment_image_url( $prop[ 'icon' ] ) ?>" alt="" />
                        <?php echo $prop[ 'name' ] ?>:
                        <span><?php echo $prop[ 'val' ] ?></span>
                </p>
                <?php endforeach ?>
            </div>

            <div class="conditions column">
                <p class="card-title">
                    <?php echo carbon_get_the_post_meta( 'requirements_title' ) ?>
                </p>
                <div class="conditions-list">
                    <?php
                    $requirements = carbon_get_the_post_meta( 'requirements' );
                    foreach ( $requirements as $requirement ):
                    ?>
                    <p class="text">
                        <img src="<?php echo wp_get_attachment_image_url( $requirement[ 'icon' ] ) ?>" alt="" />
                        <?php echo $requirement[ 'text' ] ?>
                    </p>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="user-form">
                <p class="card-title">
                    <?php _e( 'Enter your information' ) ?>
                </p>

                <form 
                    action="<?php echo admin_url( 'admin-ajax.php' ) ?>" 
                    method="POST"
                    enctype="multipart/form-data"
                    id="rent-form">
                    <input 
                        type="hidden"
                        name="action"
                        value="create_order">
                    <input 
                        type="text" 
                        placeholder="<?php _e( 'Your name' ) ?>" 
                        name="client_name" 
                        required />
                    <input 
                        type="email" 
                        name="client_email" 
                        placeholder="E-mail" 
                        required/>
                    <input 
                        type="tel" 
                        placeholder="<?php _e( 'Phone number' ) ?>" 
                        name="client_phone" 
                        required />
                </form>

            </div>

            <div class="confirm column">

                <p class="card-title">
                    <?php _e( 'Please read and confirm' ) ?> 
                    <span class="red">*</span>
                </p>
                
                <?php if ( $options = carbon_get_the_post_meta( 'rent_options' ) ): ?>
                <div class="characteristics">
                    <select name="options[0]" form="rent-form">
                        <?php
                        foreach ( $options as $option ):
                        ?>
                        <option value="<?php echo $option[ 'text' ] ?>">
                            <?php echo $option[ 'text' ] ?>
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <?php endif ?>

                <p class="text">
                    So by colonel hearted ferrars. Draw from upon here gone add one. He in sportsman household otherwise it perceived instantly. Is inquiry no he several excited am. Called though excuse length ye needed it he having.
                </p>
                
                <div class="confirm-rules column">
                    <p class="text">
                        So by colonel hearted ferrars. Draw from upon here gone add one. He in sportsman household otherwise it perceived instantly. Is inquiry no he several excited am. Called though excuse length ye needed it he having. Whatever throwing we on resolved entrance
                        together graceful. Mrs assured add private married removed believe did she.Day handsome addition horrible sensible goodness two contempt.
                    </p>
                    <div>
                        <input 
                            id="checkbox-1" 
                            class="checkbox-custom" 
                            name="checkbox-1" 
                            type="checkbox" 
                            form="rent-form" 
                            required />
                        <label 
                            for="checkbox-1" 
                            class="checkbox-custom-label">
                            I agree with rules
                        </label>
                    </div>
                </div>

                <div class="confirm-rules column">
                    <p class="text">
                        So by colonel hearted ferrars. Draw from upon here gone add one.
                        He in sportsman household otherwise it perceived instantly. Is
                        inquiry no he several excited am. Called though excuse length ye
                        needed it he having. Whatever throwing we on resolved entrance
                        together graceful. Mrs assured add private married removed
                        believe did she.Day handsome addition horrible sensible goodness
                        two contempt.
                    </p>
                    <div>
                        <input
                        id="checkbox-2"
                        class="checkbox-custom"
                        name="checkbox-2"
                        type="checkbox"
                        form="rent-form"
                        required/>
                        <label 
                        for="checkbox-2" 
                        class="checkbox-custom-label">
                        I agree with rules
                        </label>
                    </div>
                </div>

                <div class="drop column">
                    <p class="card-title">
                        So by colonel hearted ferrars.
                    </p>
                    <p class="text">
                        So by colonel hearted ferrars. Draw from upon here gone add one.
                        He in sportsman household otherwise it perceived instantly. Is
                        inquiry no he several excited am.
                    </p>
                    <div class="drop-place column">
                        <p class="section-subtitle">
                            <?php _e( 'Drop files here.' ) ?>
                        </p>
                        <div class="form-group">
                            <input
                                type="file"
                                name="client_photo"
                                id="file"
                                class="input-file"
                                form="rent-form"
                                required
                                accept="image/jpeg"/>
                            <label 
                                for="file" 
                                class="btn btn-tertiary js-labelFile">
                                <img src="./img/file.svg" alt="" />
                                <span class="js-fileName">
                                    <?php _e( 'Choose a file' ) ?>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="total column">
                    <p class="total-title card-title">
                        <?php _e( 'Totall:' ) ?>
                    </p>
                    <p class="section-title total-amount"></p>
                    <!-- <div class="subtotal">
                        <p class="text">Subtotal: <span>$3,000.00</span></p>
                    </div> -->
                    <!-- <div class="subtotal tax">
                        <p class="text">Tax: <span>$502.00</span></p>
                    </div> -->
                </div>

                <textarea
                    class="comment" 
                    name="comment" 
                    form="rent-form" 
                    placeholder="<?php _e( 'Comment' ) ?>"></textarea>

            </div>

            <button class="btn" type="submit" form="rent-form">
                <?php _e( 'Complete and pay' ) ?>
            </button>

            <p class="text require">
                <?php _e( 'Please answer all fields marked with <span>*</span> to complete your booking.' ) ?>
            </p>

        </div>

    </div>
</div>