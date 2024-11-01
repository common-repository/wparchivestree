<?php
/*
Plugin Name: WPArchivesTree
Plugin URI: https://benyam.in
Description: A widget to display a treeview of articles group by month and year
Version: 2
Author: Benyamin
Author URI: https://benyam.in
*/

/*  Copyright 2024 - Benyamin  (courriel : contact@benyam.in)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include('functions.php');

// Creating the widget 
class WPArchivesTree_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'WPArchivesTree_widget', 

			// Widget name will appear in UI
			__('WPArchivesTree Widget', 'WPArchivesTree_widget_domain'), 

			// Widget description
			array( 'description' => __( 'Display a treeview of articles', 'WPArchivesTree_widget_domain' ), )
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		
		include('frontend.php');
		
		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'WPArchivesTree_widget_domain' );
		}
		
		if ( isset( $instance[ 'dropdown' ] ) ) {
			$dropdown = $instance[ 'dropdown' ];
		}
		else {
			$dropdown = __( 'Yes', 'WPArchivesTree_widget_domain' );
		}
		
		if ( isset( $instance[ 'sort' ] ) ) {
			$sort = $instance[ 'sort' ];
		}
		else {
			$sort = __( 'Alphabetical', 'WPArchivesTree_widget_domain' );
		}
		
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'dropdown' ); ?>"><?php _e( 'Display first element :' ); ?></label> 
			<select name="<?php echo $this->get_field_name( 'dropdown' ); ?>" id="<?php echo $this->get_field_id( 'dropdown' ); ?>">
				<option <?php if(esc_attr($dropdown) == 'yes') echo 'selected="selected"'; ?> value="yes">Yes</option>
				<option <?php if(esc_attr($dropdown) == 'no') echo 'selected="selected"'; ?> value="no">No</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'sort' ); ?>"><?php _e( 'Sort elements by :' ); ?></label> 
			<select name="<?php echo $this->get_field_name( 'sort' ); ?>" id="<?php echo $this->get_field_id( 'sort' ); ?>">
				<option <?php if(esc_attr($sort) == 'alphabeticalasc') echo 'selected="selected"'; ?> value="alphabeticalasc">Alphabetical ASC</option>
				<option <?php if(esc_attr($sort) == 'alphabeticaldesc') echo 'selected="selected"'; ?> value="alphabeticaldesc">Alphabetical DESC</option>
			</select>
		</p>
	<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['dropdown'] = ( ! empty( $new_instance['dropdown'] ) ) ? strip_tags( $new_instance['dropdown'] ) : '';
		$instance['sort'] = ( ! empty( $new_instance['sort'] ) ) ? strip_tags( $new_instance['sort'] ) : '';
		return $instance;
	}
} // Class WPArchivesTree_widget ends here

// Register and load the widget
function WPArchivesTree_load_widget() {
	register_widget( 'WPArchivesTree_widget' );
}
add_action( 'widgets_init', 'WPArchivesTree_load_widget' );

/**
 * Proper way to enqueue scripts and styles
 */
function theme_name_scripts() {
	wp_enqueue_style('WPArchivesTree-style', plugins_url( '/css/style.css', __FILE__ ));
	wp_enqueue_script('WPArchivesTree-script', plugins_url( '/js/script.js', __FILE__ ), array(), false, array('in_footer' => true));
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
?>