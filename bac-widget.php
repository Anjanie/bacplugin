<?php	
/*
	Plugin Name: BA Clothiers Custom Post and Social Platform Widget
	Description: Customs posts Social Platform Links 
	Plugin URI: http://google.com
	Author: Bisma Ayyaz, Anmol Joy, Anjanie Rupnarain
	Author URI: http://google.com
	License: GPL2
	Version: 1.0
*/

//Code taken from the website: http://designmodo.com/wordpress-social-media-widget/
// Create the Widget
class BacSocialMediaClotheirs extends WP_Widget {

    // Initialize the Widget
    public function __construct() {
        parent::__construct('BacSocialMediaClotheirs', __('Social Platforms', 'translation_domain'), 
                array('description' => __('Social Platform Links', 'translation_domain'),)
        );
    }

// Determines what will appear on the site
   
    public function widget($args, $instance) {

        $title = apply_filters('widget_title', $instance['title']);
        $facebook = $instance['facebook'];
        $google = $instance['google'];
       
// social platform links
        $facebook_profile = '<a class="facebook" href="' . $facebook . '"><i class="fa fa-facebook"></i></a>';
        $google_profile = '<a class="google" href="' . $google . '"><i class="fa fa-google-plus"></i></a>';
        

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo '<div class="logos">';
        echo (!empty($facebook) ) ? $facebook_profile : null;
        echo (!empty($google) ) ? $google_profile : null;
        echo '</div>';

        echo $args['after_widget'];
    }

  // Sets up the form for users to set their options/add content in the widget admin page- Back-end
    public function form($instance) {
        isset($instance['title']) ? $title = $instance['title'] : null;
        empty($instance['title']) ? $title = 'Bac Social Platform' : null;

        isset($instance['facebook']) ? $facebook = $instance['facebook'] : null;
        isset($instance['twitter']) ? $twitter = $instance['twitter'] : null;
        isset($instance['google']) ? $google = $instance['google'] : null;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('google'); ?>"><?php _e('Google+:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('google'); ?>" name="<?php echo $this->get_field_name('google'); ?>" type="text" value="<?php echo esc_attr($google); ?>">
        </p>

<?php

    }

// Sanitizes, saves and submits the user-generated content. 
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['facebook'] = (!empty($new_instance['facebook']) ) ? strip_tags($new_instance['facebook']) : '';
        $instance['google'] = (!empty($new_instance['google']) ) ? strip_tags($new_instance['google']) : '';

        return $instance;
    }

}
// register Bac Widget
function register_bacsocialmediaclotheirs() {
    register_widget('BacSocialMediaClotheirs');
}

add_action('widgets_init', 'register_bacsocialmediaclotheirs');
    
// enqueuing css stylesheet
function bacsocialmediaclotheirs_widget_css() {
    wp_enqueue_style('social-profile-widget', plugins_url('bacsocialmediaclotheirs-widget.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'bacsocialmediaclotheirs_widget_css');
    




//Second Widget   - Custom Posts Widget

function bac_custom_widget_init() {
if ( !function_exists( 'register_sidebar_widget' ))
return;

function bac_custom_widget($args) {
global $post;
extract($args);

// These are our own options
$options = get_option( 'bac_custom_widget' );
$title = $options['title']; // Widget title
$phead = $options['phead']; // Heading format
$ptype = $options['ptype']; // Post type
$pshow = $options['pshow']; // Number of Tweets

$beforetitle = '';
$aftertitle = '';

// Output
echo $before_widget;

if ($title) echo $beforetitle . $title . $aftertitle;

$pq = new WP_Query(array( 'post_type' => $ptype, 'showposts' => $pshow ));
if( $pq->have_posts() ) :
?>
<ul>
<ul><?php while($pq->have_posts()) : $pq->the_post(); ?>
    <li><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></li>
</ul>
</ul>
<?php wp_reset_query();
endwhile; ?>

<?php endif; ?>

<!-- NEEDS FIX: to display link to full list of posts page
<?php $obj = get_post_type_object($ptype); ?>
<div class="latest_cpt_icon"><a href="<?php site_url('/'.$obj->query_var); ?>" rel="bookmark"><?php _e( 'View all ' . $obj->labels->name . ' posts' ); ?>&rarr;</a></div>
//-->

<?php
// echo widget closing tag
echo $after_widget;
}

/**
* Widget settings form function
*/
function bac_custom_widget_control() {

// Get options
$options = get_option( 'bac_custom_widget' );
// options exist? if not set defaults
if ( !is_array( $options ))
$options = array(
'title' => 'Latest Posts',
'phead' => 'h2',
'ptype' => 'post',
'pshow' => '3'
);
// form posted?
if ( $_POST['latest-bac-submit'] ) {
$options['title'] = strip_tags( $_POST['latest-bac-title'] );
$options['phead'] = $_POST['latest-bac-phead'];
$options['ptype'] = $_POST['latest-bac-ptype'];
$options['pshow'] = $_POST['latest-bac-pshow'];
update_option( 'bac_custom_widget', $options );
}
// Get options for form fields to show
$title = $options['title'];
$phead = $options['phead'];
$ptype = $options['ptype'];
$pshow = $options['pshow'];

// The widget form fields
?>

<label for="latest-bac-title"><?php echo __( 'Widget Title' ); ?>
<input id="latest-bac-title" type="text" name="latest-bac-title" size="30" value="<?php echo $title; ?>" />
</label>

<label for="latest-bac-phead"><?php echo __( 'Widget Heading Format' ); ?></label>

<select name="latest-bac-phead"><option selected="selected" value="h2">H2 - <h2></h2></option><option selected="selected" value="h3">H3 - <h3></h3></option><option selected="selected" value="h4">H4 - <h4></h4></option><option selected="selected" value="strong">Bold - <strong></strong></option></select><select name="latest-bac-ptype"><option value="">- <?php echo __( 'Select Post Type' ); ?> -</option></select><?php $args = array( 'public' => true );
$post_types = get_post_types( $args, 'names' );
foreach ($post_types as $post_type ) { ?>

<select name="latest-bac-ptype"><option selected="selected" value="<?php echo $post_type; ?>"><?php echo $post_type;?></option></select><?php } ?>

<label for="latest-bac-pshow"><?php echo __( 'Number of posts to show' ); ?>
<input id="latest-bac-pshow" type="text" name="latest-bac-pshow" size="2" value="<?php echo $pshow; ?>" />
</label>

<input id="latest-bac-submit" type="hidden" name="latest-bac-submit" value="1" />
<?php
}

wp_register_sidebar_widget( 'widget_latest_bac', __('Latest Custom Posts'), 'bac_custom_widget' );
wp_register_widget_control( 'widget_latest_bac', __('Latest Custom Posts'), 'bac_custom_widget_control', 300, 200 );

}
add_action( 'widgets_init', 'bac_custom_widget_init' ); 


