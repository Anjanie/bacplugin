<?php	
/*
	Plugin Name: BA Clothiers Widget - 1
	Description: This is a widget to display yearly archives.
	Plugin URI: http://google.com
	Author: Bisma Ayyaz, Anmol Joy, Anjanie Rupnarain
	Author URI: http://google.com
	License: GPL2
	Version: 1.0
*/


// Creating the Widget

class CDYearlyArchivesWidget extends WP_Widget {
	
	// Initializing the Widget
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_archive', 
			'description' => __( 'A yearly archive of your site&#8217;s posts.', 'codediva') 
	);
		// Adds a class to the widget and provides a description on the Widget page to describe what the widget does.
		parent::__construct('yearly_archives', __('Yearly Archives', 'codediva'), $widget_ops);
	}
	
	
	// The Code Below Determines what will appear on the site
	public function widget( $args, $instance ) {
		$c = ! empty( $instance['count'] ) ? '1' : '0'; 
		//sets a variable for whether or not the 'Count' option is checked
		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';
		// sets a variable for whether or not the 'Dropdown' option is checked
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Yearly Archives', 'codediva') : $instance['title'], $instance, $this->id_base); 
		// Determines if there's a user-provided title and if not, displays a default title.
		
		echo $args['before_widget']; // what's set up when you registered the sidebar
		
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

	if ( $d ) {
		//if the dropdown option is checked, gets a list of the archives and displays them by year in a dropdown list. 
		$dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $dropdown_id ); ?>"><?php echo $title; ?></label>
		<select id="<?php echo esc_attr( $dropdown_id ); ?>" name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'>
			
		<?php	$dropdown_args = apply_filters( 'widget_archives_dropdown_args', array(
				'type'            => 'yearly',
				'format'          => 'option',
				'show_post_count' => $c // If post count checked, show the post count
			) );
		?>	
			<option value="<?php echo __( 'Select Year', 'codediva' ); ?>"><?php echo __( 'Select Year', 'codediva' ); ?></option>
			<?php wp_get_archives( $dropdown_args ); ?>
		</select>
<?php
	} else {
		// If (d) not selected, show this:
?>
		<ul>
		<?php 
			wp_get_archives( apply_filters( 'widget_archives_args', array(
			'type'            => 'yearly',
			'show_post_count' => $c
		) ) ); 
			// gets a list of the archives and displays them by year. If the Count option is checked, this gets shown.
		?>
		</ul>

<?php
		}
		
		echo $args['after_widget']; // what's set up when you registered the sidebar
	}
	
	// Sets up the form for users to set their options/add content in the widget admin page
	
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
		$title = strip_tags($instance['title']);
		$count = $instance['count'] ? 'checked="checked"' : '';
		$dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'codediva'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> 
			<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as dropdown', 'codediva'); ?></label>
			<br/>
			<input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> 
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post count', 'codediva'); ?></label>
		</p>
<?php }
	
	// Sanitizes, saves and submits the user-generated content.
	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = $new_instance['count'] ? 1 : 0;
		$instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

		return $instance;
	}
}

// Tells WordPress that this widget has been created and that it should display in the list of available widgets.

add_action( 'widgets_init', function(){
     register_widget( 'CDYearlyArchivesWidget' );
});