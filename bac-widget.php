<?php	
/*
	Plugin Name: BAC Custom Post and Social Platform Widget
	Description: Customs posts and Social Platform Links 
	Plugin URI: http://google.com
	Author: Bisma Ayyaz, Anmol Joy, Anjanie Rupnarain
	Author URI: http://google.com
	License: GPL2
	Version: 1.0
*/

//Code has been referenced from the website: http://designmodo.com/wordpress-social-media-widget/
// Code below creates the social media platform widget for bac clotheirs.
class BacSocialMediaClotheirs extends WP_Widget {

    // Code below initializes the widget for social media platforms (facebook and Google plus) for bac.
    public function __construct() {
        parent::__construct('BacSocialMediaClotheirs', __('Social Platforms', 'translation_domain'), 
                array('description' => __('Social Platform Links', 'translation_domain'),)
        );
    }

// Code below will determine what will appear on the main site, meaning at the front end.
   
    public function widget($args, $instance) {

        $title = apply_filters('widget_title', $instance['title']);
        $facebook = $instance['facebook'];
        $google = $instance['google'];
       
// code below has the social platform links
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

// This code below sanitizes (meaning sanitizing the widget form values as soon as they are saved), saves and then submits the user-generated content. 
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['facebook'] = (!empty($new_instance['facebook']) ) ? strip_tags($new_instance['facebook']) : '';
        $instance['google'] = (!empty($new_instance['google']) ) ? strip_tags($new_instance['google']) : '';

        return $instance;
    }

}
// Code below registers BA Clotheirs Socail Media Platform widget.
function register_bacsocialmediaclotheirs() {
    register_widget('BacSocialMediaClotheirs');
}

add_action('widgets_init', 'register_bacsocialmediaclotheirs');
    
// Code below is enqueuing the css stylesheet for the plugin
function bacsocialmediaclotheirs_widget_css() {
    wp_enqueue_style('social-profile-widget', plugins_url('bacsocialmediaclotheirs-widget.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'bacsocialmediaclotheirs_widget_css');
    
//This is another Custom Post Type widget for BA Clotheirs 
//It is referenced from https://premium.wpmudev.org/blog/how-to-make-a-sidebar-widget-to-display-recent-custom-posts-by-jared-williams/

function bac_custom_widget_init() {
if ( !function_exists( 'register_sidebar_widget' ))
return;

function bac_custom_widget($args) {
global $post;
extract($args);

// Code below shows the options available to change from the Wordpress.
$options = get_option( 'bac_custom_widget' );
// Title of the widget.
$title = $options['title']; 
// Format of the geading of the widget.
$phead = $options['phead']; 
// Post type
$ptype = $options['ptype']; 
// Number of Posts to be shown
$pshow = $options['pshow']; 

$beforetitle = '';
$aftertitle = '';

// Code below is the output of the widget
echo $before_widget;

if ($title) echo $beforetitle . $title . $aftertitle;

$pq = new WP_Query(array( 'post_type' => $ptype, 'showposts' => $pshow ));
if( $pq->have_posts() ) :
?>
<ul>
<ul><?php while($pq->have_posts()) : $pq->the_post(); ?>
    <li><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?><?php the_post_thumbnail(); ?></a></li>
</ul>
</ul>
<?php wp_reset_query();
endwhile; ?>

<?php endif; ?>


<?php
// Code below is echoing the widget closing tag
echo $after_widget;
}

/**
* Widget settings form function
*/
function bac_custom_widget_control() {

// Code to get options from the database
$options = get_option( 'bac_custom_widget' );
// If options  do not exist then the default setting will be set.
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
// Code below is getting options for form fields to show
$title = $options['title'];
$phead = $options['phead'];
$ptype = $options['ptype'];
$pshow = $options['pshow'];

// Code below is the form fields for the custom post widget.
?>

<label for="latest-bac-title"><?php echo __( 'Widget Title' ); ?>
<input id="latest-bac-title" type="text" name="latest-bac-title" size="30" value="<?php echo $title; ?>" />
</label>

<label for="latest-bac-phead"><?php echo __( 'Widget Heading Format' ); ?></label>

<select name="latest-bac-phead"><option selected="selected" value="h2">H2 - <h2></h2></option><option selected="selected" value="h3">H3 - <h3></h3></option><option selected="selected" value="h4">H4 - <h4></h4></option><option selected="selected" value="strong">Bold - <strong></strong></option></select><select name="latest-bac-ptype"><option value="">- <?php echo __( 'Select Post Type' ); ?> -</option></select><?php $args = array( 'public' => true );
$post_types = get_post_types( $args, 'names' );
foreach ($post_types as $post_type ) { ?>

<select name="latest-bac-ptype"><option selected="selected" value="<?php echo $post_type; ?>"><?php echo $post_type;?></option></select><?php } ?>


<label for="latest-bac-pshow"><?php echo __( 'Number of posts to be shown' ); ?>
<input id="latest-bac-pshow" type="text" name="latest-bac-pshow" size="2" value="<?php echo $pshow; ?>" />
</label>

<input id="latest-bac-submit" type="hidden" name="latest-bac-submit" value="1" />
<?php
}

// Code below is for registering the bac custom post type widget.
wp_register_sidebar_widget( 'widget_latest_bac', __('Latest Custom Posts'), 'bac_custom_widget' );
wp_register_widget_control( 'widget_latest_bac', __('Latest Custom Posts'), 'bac_custom_widget_control', 300, 200 );

}
add_action( 'widgets_init', 'bac_custom_widget_init' ); 


