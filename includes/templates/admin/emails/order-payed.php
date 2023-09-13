<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        <?php bloginfo( 'name' ) ?> | <?php _e( 'Order payed' ) ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        /**
        * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
        */
        
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
        }
        /**
        * Avoid browser level font resizing.
        * 1. Windows Mobile
        * 2. iOS / OSX
        */
        
        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
        }
        /**
        * Remove extra space added to tables and cells in Outlook.
        */
        
        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }
        /**
        * Better fluid images in Internet Explorer.
        */
        
        img {
            -ms-interpolation-mode: bicubic;
        }
        /**
        * Remove blue links for iOS devices.
        */
        
        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }
        /**
        * Fix centering issues in Android 4.4.
        */
        
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
        
        body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        /**
        * Collapse table borders to avoid space between cells.
        */
        
        table {
            border-collapse: collapse !important;
        }
        
        a {
            color: #1a82e2;
        }
        
        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }
    </style>

</head>

<body style="background-color: #e9ecef;">

    <!-- start preheader -->
    <!-- <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
        <?php echo get_the_title( $order->car_id ) ?>
    </div> -->
    <!-- end preheader -->

    <!-- start body -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">

        <!-- start logo -->
        <tr>
            <td align="center" bgcolor="#e9ecef">
                <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 15px 12px;background:#d4dadf;">
                            <a href="<?php echo get_the_permalink( $order->car_id ) ?>" target="_blank" style="display: inline-block;">
                                <img src="<?php echo get_the_post_thumbnail_url( $order->car_id, 'full' ) ?>" alt="" border="0" width="100" style="display: block; width: 200px; max-width: 200px; min-width: 200px;">
                            </a>
                        </td>
                    </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
            </td>
        </tr>
        <!-- end logo -->

        <!-- start hero -->
        <tr>
            <td align="center" bgcolor="#e9ecef">
                <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
                            <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">
                                <?php echo get_the_title( $order->car_id ) ?>
                            </h1>
                        </td>
                    </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
            </td>
        </tr>
        <!-- end hero -->

        <!-- start copy block -->
        <tr>
            <td align="center" bgcolor="#e9ecef">
                <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                    <!-- start copy -->
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                            
                            <p style="margin: 0 0 10px 0;">
                                <b><?php _e( 'From' ) ?></b> 
                                <?php echo datetime( $order->start )->format( 'm/d/Y h:i A' ) ?>
                                <b><?php _e( 'To' ) ?></b> 
                                <?php echo datetime( $order->end )->format( 'm/d/Y h:i A' ) ?>
                            </p>

                            <?php
                            $options = json_decode( $order->options, true );
                            foreach ( $options as $name => $value ): ?>
                                <p style="margin: 0;">
                                    <b><?php echo $name ?></b> <?php echo $value ?>
                                </p>
                            <?php endforeach ?>
    
                            <p style="margin: 10px 0 0 0;">
                                <b><?php _e( 'Price' ) ?></b> $<?php echo $order->price ?>
                            </p>

                        </td>
                    </tr>
                    <!-- end copy -->

                    <!-- start button -->
                    <tr>
                        <td align="left" bgcolor="#ffffff">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                                                    <a href="<?php echo home_url() ?>" target="_blank" style="display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">
                                                        <?php _e( 'Go to site' ) ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- end button -->

                    <!-- start copy -->
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;">
                                <?php _e( 'if you have problems' ) ?>:
                            </p>
                            <p style="margin: 0;"><a href="tel:<?php echo get_carsharing_option( 'phone' ) ?>" target="_blank"><?php echo get_carsharing_option( 'phone' ) ?></a></p>
                            <p style="margin: 0;"><a href="mailto:<?php echo get_carsharing_option( 'notification_email' ) ?>" target="_blank"><?php echo get_carsharing_option( 'notification_email' ) ?></a></p>
                        </td>
                    </tr>
                    <!-- end copy -->

                </table>
                <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
            </td>
        </tr>
        <!-- end copy block -->

    </table>
    <!-- end body -->

</body>

</html>