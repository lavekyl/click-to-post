<?php
/**
 * Plugin Name: Facebook Click to Post
 * Plugin URI: https://github.com/lavekyl/click-to-post
 * Description: This is the Facebook click to post plugin.
 * Version: 1.0
 * Author: Kyle Laverty
 * Author URI: https://www.kylelaverty.com/
 **/

// Add Shortcode
function fb_click_to_post( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'quote' => '',
			'href'  => '',
		),
		$atts
	);

    return '<div class="facebook-quote">
                <div id="fb-root"></div>
                <div class="fb-quote" data-href="'. $atts['href'] . '"></div>
                <div class="fb-quotable"><p>'. $atts['quote'] . '</p></div>
                <a href="https://www.facebook.com/sharer/sharer.php?u=' . $atts['href'] . '&display=popup&ref=plugin&src=quote&quote=' . $atts['quote'] . '" target="_blank" class="click-to-quote">Click to Post <i class="fa fa-facebook-f" aria-hidden="true"></i></a>
            </div>';

}
add_shortcode( 'facebook_quote', 'fb_click_to_post' );

function facebook_quote_script() {
    if ( shortcode_exists( 'facebook_quote' ) ) {
        global $wp_styles;
        $srcs = array_map( 'basename', (array) wp_list_pluck( $wp_styles->registered, 'src' ) );
        if ( in_array( 'font-awesome.css', $srcs ) || in_array( 'font-awesome.min.css', $srcs )  ) {
            // echo 'font-awesome.css registered';
        } else {
            wp_enqueue_style( 'font-awesome', '//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0' );
        }
        wp_enqueue_script( 'fb_custom_script', plugin_dir_url( __FILE__ ) . 'facebook-quote.js' );
    }
}
add_action( 'wp_enqueue_scripts', 'facebook_quote_script' );
