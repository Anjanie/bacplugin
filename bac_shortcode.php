<?php
/*
 * Plugin Name: BA Clothiers Shortcode
 * Plugin URI: http://google.com
 * Description: Shortcode for changing the number of posts.
 * Author: Anjanie Rupnarain, Anmol Joy John, Bisma Ayyaz
 * Author URI: http://google.com
 * Version: 1.0
 */
 
//This piece of code enqueues the stylesheet.

function ba_clothiers_enqueue_scripts(){
	wp_enqueue_style('plugins', plugins_url('plugins/css/style.css'));
}
add_action('wp_enqueue_scripts', 'ba_clothiers_enqueue_scripts');

//The custom post type with thumbnails
    
function content_custom_post_type() {
        register_post_type( 'content',
            array(
                'labels' => array(
                    'name' => __( 'content' ),
                    'singular_name' => __( 'content' )
                ),
                'public' => true,
                'has_archive' => true
            )
        );
    }
    add_action( 'init', 'content_custom_post_type' );
    add_post_type_support( 'content', 'thumbnail' );

//This code adds a shortcode button on the back end of wordpress.
    add_shortcode( 'content_shortcode', 'content_short_code' );

//This code calls onto the shortcode function.
    function content_short_code(){
        $args = array(
            'post_type' => 'content', //
            'post_status' => 'publish',
			'posts_per_page' => 3
        );
 $string = '';
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();
                $string .= get_the_title() . the_post_thumbnail();
            }
        }
        wp_reset_postdata();
        return $string;
       
    }

	
 /* referened from http://codex.wordpress.org/Class_Reference/WP_Query, 
 http://wordpress.stackexchange.com/questions/183538/display-custom-post-type-with-shortcode, and
 https://codex.wordpress.org/Function_Reference/wp_reset_postdata */