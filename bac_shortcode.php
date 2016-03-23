<?php
/*
 * Plugin Name: BA Clothiers Shortcode
 * Plugin URI: http://google.com
 * Description: Shortcode for changing the number of posts.
 * Author: Anjanie Rupnarain, Anmol Joy John, Bisma Ayyaz
 * Author URI: http://google.com
 * Version: 1.0
 */
 
//This piece of code enqueues the stylesheet for the shortcode.

function ba_clothiers_enqueue_scripts(){
	wp_enqueue_style('plugins', plugins_url('plugins/css/style.css'));
}
add_action('wp_enqueue_scripts', 'ba_clothiers_enqueue_scripts');

//The custom post type that displays the thumbnails featured image option for each post.
    
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
    add_post_type_support( 'content', 'thumbnail' ); // referenced from http://wordpress.stackexchange.com/questions/51897/how-come-featured-image-isnt-showing-up-in-my-custom-post-type

//This code adds a shortcode button on the back end of wordpress.
    add_shortcode( 'content_shortcode', 'content_short_code' );

//This code calls onto the shortcode function.
/* referened from http://codex.wordpress.org/Class_Reference/WP_Query, 
 http://wordpress.stackexchange.com/questions/183538/display-custom-post-type-with-shortcode, and
 https://codex.wordpress.org/Function_Reference/wp_reset_postdata */
    function content_short_code(){
        $args = array(
            'post_type' => 'content', //the post type that will be displayed from this shortcode is the content of the posts.
            'post_status' => 'publish', //the content of the post will be published for users to see.
			'posts_per_page' => 3 //only three posts from the post type will appear on the designated page.
        );
 $string = '';
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $string .= '<p>';
				$query->the_post();
                $string .= '<p>' . get_the_title() . the_post_thumbnail() . '</p>'; //This code will display the title of the post and the featured image thumbnail.
            }
			$string .= '</p>';
        }
        wp_reset_postdata();
        return $string;
		
       
    }