<?php	
/*
	Plugin Name: BA Clothiers Social Platform Widget
	Description: Social Platform Links 
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
    
    
    
    
    
    
    
    
    
    
    
    
    
