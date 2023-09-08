<div class="wrap tabs">

    <div class="tabs__head">

        <div class="tabs__heading" data-target="orders">
            <?php _e( 'Orders' ) ?>
        </div>

        <div class="tabs__heading" data-target="latest" data-page-number="1">
            <?php _e( 'Latest' ) ?>
        </div>

        <div class="tabs__heading" data-target="pricing">
            <?php _e( 'Pricing' ) ?>
        </div>

        <div class="tabs__heading" data-target="analytics">
            <?php _e( 'Analytics' ) ?>
        </div>

        <div class="tabs__heading" data-target="settings">
            <?php _e( 'Settings' ) ?>
        </div>

    </div>

    <div class="tabs__body">

        <div class="tabs__item" data-page="orders">

            <?php require_once CARSHARING_ROOT . '/includes/templates/admin/pages/orders.php' ?>

        </div>

        <div class="tabs__item" data-page="latest">

            <div class="latest">

            </div>

        </div>

        <div class="tabs__item" data-page="pricing">

            <?php require_once CARSHARING_ROOT . '/includes/templates/admin/pages/pricing.php' ?>

        </div>

        <div class="tabs__item" data-page="analytics">

            <?php require_once CARSHARING_ROOT . '/includes/templates/admin/pages/analytics.php' ?>

        </div>

        <div class="tabs__item" data-page="settings">

            <?php require_once CARSHARING_ROOT . '/includes/templates/admin/pages/settings.php' ?>

        </div>

    </div>

</div>