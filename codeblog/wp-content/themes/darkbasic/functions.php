<?php register_sidebars(1); ?>
<?php if ( ! isset( $content_width ) ) $content_width = 640; /*max image/vid width for posts*/ ?>
<?php add_theme_support('automatic-feed-links'); ?>
<?php add_theme_support('post-thumbnails'); ?>
<?php add_filter( 'use_default_gallery_style', '__return_false' ); //takes out hardcoded gallery stuff ?>
<?php
//Check see if the customisetheme_setup exists
if ( !function_exists('customisetheme_setup') ):
    //Any theme customisations contained in this function
    function customisetheme_setup() {
        //Define default header image
        define( 'HEADER_IMAGE', '' );
        //Define the width and height of our header image
        define( 'HEADER_IMAGE_WIDTH', apply_filters( 'customisetheme_header_image_width', 1000 ) );
        define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'customisetheme_header_image_height', 288 ) );
        //Turn off text inside the header image
        define( 'NO_HEADER_TEXT', true );
        define( 'HEADER_TEXTCOLOR','C0C0C0' );
        //Don't forget this, it adds the functionality to the admin menu
        add_custom_image_header( '', 'customisetheme_admin_header_style' );
        $customHeaders = array(
			'default-header' => array(
			'url' => '%s/default-header.jpg',
			'thumbnail_url' => '%s/default-header-thumb.jpg',
			'description' => 'Photo I took while in Spain, no idea where.','darkbasic'
		));
        //Register the images with Wordpress
        register_default_headers($customHeaders);
    }
endif;
if ( ! function_exists( 'customisetheme_admin_header_style' ) ) :
    //Function fired and inline styles added to the admin panel
    //Customise as required
    function customisetheme_admin_header_style() {
    ?>
        <style type="text/css">
            #wpbody-content #headimg {
                height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
                width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
                border: 0;
            }
        </style>
    <?php
    }
endif;
//Execute our custom theme functionality
add_action( 'after_setup_theme', 'customisetheme_setup' );
?>