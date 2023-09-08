<?php get_header() ?>

<div class="hero" style="background-image: url('<?php echo wp_get_attachment_image_url( carbon_get_the_post_meta( 'first_bg' ), 'full' ) ?>')">
    <div class="container">

        <!-- <div class="breadcrambs">
            <a href="" class="breadcrambs-item">Home</a>
            <a href="" class="breadcrambs-item">Home</a>
            <a href="" class="breadcrambs-item">Home</a>
        </div> -->

        <div class="card column">

            <h1 class="section-title">
                <?php echo carbon_get_the_post_meta( 'first_title' ) ?>
            </h1>

            <p class="text">
                <?php echo carbon_get_the_post_meta( 'first_text' ) ?>
            </p>

            <div class="info-btn">
                <a href="#" class="btn">
                    <?php _e( 'Rent a car' ) ?>
                </a>
                <a href="#" class="btn gallery">
                    <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' )  ?>/includes/assets/public/img/gallery.svg" alt="" />
                    <?php _e( 'View photos' ) ?>
                </a>
            </div>

        </div>

        <div class="options-price">
            <?php
            $prices = ( new Carsharing_Price )->get( get_the_ID() );
            foreach ( $prices as $time => $price ):
            ?>
                <div class="options-price-item">
                    <p class="hour">
                        <?php echo format_rent_time( $time ) ?>
                    </p>
                    <div class="card">
                        <p class="price section-title">
                            $
                            <?php echo $price ?>
                        </p>
                        <p class="section-subtitle">
                            <?php _e( '+ tax' ) ?>
                        </p>
                    </div>
                </div>
                <?php endforeach ?>
        </div>

    </div>
</div>

<section class="rent-info">
    <div class="container">

        <div class="left">

            <div class="about column">
                <h2 class="section-title">
                    <?php echo carbon_get_the_post_meta( 'desc_title' ) ?>
                </h2>
                <p class="text">
                    <?php echo carbon_get_the_post_meta( 'desc_text' ) ?>
                </p>
            </div>

            <div class="charact column">
                <p class="card-title">
                    <?php _e( 'Characteristics' ) ?>:
                </p>
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
            </div>

            <div class="car-advantages">
                <?php
                $advans = carbon_get_the_post_meta( 'advan_items' );
                foreach ( $advans as $advan ):
                ?>
                    <div class="advantages-item column">
                        <img src="<?php echo wp_get_attachment_image_url( $advan[ 'icon' ] ) ?>" alt="" />
                        <p class="card-title">
                            <?php echo $advan[ 'title' ] ?>
                        </p>
                        <p class="text">
                            <?php echo $advan[ 'text' ] ?>
                        </p>
                    </div>
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

            <div class="video-container" id="video-container">

                <video preload="" controls id="video" poster="<?php echo wp_get_attachment_image_url( carbon_get_the_post_meta( 'poster' ), 'full' ) ?>">
                    <source
                        src="<?php echo wp_get_attachment_url( carbon_get_the_post_meta( 'video' ) ) ?>"
                        type="<?php echo get_post_mime_type( carbon_get_the_post_meta( 'video' ) ) ?>"/>
                </video>

                <div class="play-button-wrapper">
                    <div title="Play video" class="play-gif" id="circle-play-b">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                            <path d="M40 0a40 40 0 1040 40A40 40 0 0040 0zM26 61.56V18.44L64 40z"/>
                        </svg>
                    </div>
                </div>

            </div>

        </div>

        <div class="right">

            <p class="section-title">
                <?php _e( 'Fill out the form to rent a car.' ) ?>
            </p>

            <div id="rent-calendar"></div>

            <div class="time-select _hidden">

                <p class="card-title selected-date"></p>

                <div class="time-variants">
                    <?php
                    $hours = explode( ',', get_carsharing_option( 'rent_hours' ) );
                    foreach ( $hours as $hour ): $hour = datetime( $hour );
                    ?>
                        <div class="time-variants-item" data-hour="<?php echo $hour->format( 'H:i' ) ?>">

                            <div class="top">
                                <p class="text">
                                    <?php echo $hour->format( 'h:i a' ) ?>
                                </p>
                                <!-- <p class="text rem">
                                <img src="./img/person.svg" alt="" /> 1 left
                            </p> -->
                            </div>

                            <div class="card-title selected-car">
                                <?php the_title() ?>
                                <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' )  ?>/includes/assets/public/img/arrowRight.svg" alt="" />
                            </div>

                        </div>
                        <?php endforeach ?>
                </div>

            </div>

            <div class="hours _hidden">
            </div>

            <div class="btn next-step _hidden">
                <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' )  ?>/includes/assets/public/img/arrowRightFF.svg" alt="" />
                <?php _e( 'Next step' ) ?>
            </div>

        </div>

    </div>
</section>

<?php require_once CARSHARING_ROOT . '/includes/templates/public/popups/rent.php' ?>

<section class="contactUs">
    <div class="card column">
        <p class="section-subtitle">
            <?php _e( 'Contact us' ) ?>
        </p>
        <h2 class="section-title">
            <?php _e( 'Having trouble renting or have additional questions?' ) ?>
        </h2>
        <div class="buttons">
            <a href="tel:<?php echo get_carsharing_option( 'phone' ) ?>" class="btn">
                <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' )  ?>/includes/assets/public/img/tel.svg" alt="" />
                <?php _e( 'Call us' ) ?>
            </a>
            <a href="mailto:<?php echo get_carsharing_option( 'notification_email' ) ?>" class="btn">
                <img src="<?php echo plugin_dir_url( CARSHARING_ROOT . '/carsharing.php' )  ?>/includes/assets/public/img/mail.svg" alt="" />
                <?php _e( 'Email us' ) ?>
            </a>
        </div>
    </div>
</section>

<section class="similar">
    <div class="container column">
        <p class="section-subtitle">
            <?php _e( 'Similar cars' ) ?>
        </p>
        <h2 class="section-title">
            <?php _e( 'Hand two was eat <br /> busy fail.' ) ?>
        </h2>
        <ul class="similar-list">
            <?php
            $cars = get_posts( [
                'post_type' => 'car',
                'numberposts' => 3,
                'exclude' => [ get_the_ID(), ],
            ] );
            foreach ( $cars as $car ):
            ?>
            <li class="car-item">
                <img src="<?php echo get_the_post_thumbnail_url( $car->ID ) ?>" alt="" />
                <div class="card column">
                    <p class="section-title">
                        <?php echo get_the_title( $car->ID ) ?>
                    </p>
                    <div class="charact-list">
                        <?php
                        $props = carbon_get_post_meta( $car->ID, 'prop_items' );
                        foreach ( $props as $prop ):
                        ?>
                        <p class="text">
                            <img src="<?php echo wp_get_attachment_image_url( $prop[ 'icon' ] ) ?>" alt="" />
                            <?php echo $prop[ 'name' ] ?>:
                            <span><?php echo $prop[ 'val' ] ?></span>
                        </p>
                        <?php endforeach ?>
                    </div>
                    <a href="<?php echo get_the_permalink( $car->ID ) ?>" class="btn">
                        <?php _e( 'Rent now' ) ?>
                    </a>
                </div>
            </li>
            <?php endforeach ?>
        </ul>
    </div>
</section>

<?php get_footer() ?>