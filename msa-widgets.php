<?php
/*
Plugin Name: MSA Widget
Description: Custom widget for MSA site
*/

/**
 * Notes: use with taxonomy-{tax_name}.php, custom page with custom code to show custom posty type for custom taxonomy.
 */

require_once( plugin_dir_path( __FILE__ ) . "include/msa-book-navigation.php" );

// Register and load the widget
function msa_load_widget() {
    register_widget( 'msa_widgets' );
}
add_action( 'widgets_init', 'msa_load_widget' );

// Creating the widget 
class msa_widgets extends WP_Widget {
 
	function __construct() {
		parent::__construct(
		 
		// Base ID of your widget
		'msa_widgets', 
		 
		// Widget name will appear in UI
		__('MSA Widgets', 'msa_widget_domain'), 
		 
		// Widget description
		array( 'description' => __( 'Custom code to help with MSA sections', 'msa_widget_domain' ), ) 
		);
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$tax = apply_filters( 'widget_tax', $instance['tax'] );
		 
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		 
		// This is where you run the code and display the output
		$output = msa_taxonomy_terms( $tax );

		echo __( $output, 'wpb_widget_domain' );
		echo $args['after_widget'];
	}	

	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'msa_widget_domain' );
		}

		if ( isset( $instance[ 'tax'] ) ) {
			$tax = $instance[ 'tax' ];
		} else {
			$tax  = '';
		}

		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

			<label for="<?php echo $this->get_field_id( 'tax' ); ?>"><?php _e( 'Taxonomy' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'tax' ); ?>" name="<?php echo $this->get_field_name( 'tax' ); ?>" type="text" value="<?php echo esc_attr( $tax ); ?>" />
		</p>
		<?php 
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['tax'] = ( ! empty( $new_instance['tax'] ) ) ? strip_tags( $new_instance['tax'] ) : '';
		
		return $instance;
	}		

} // Class wpb_widget ends here

if ( ! function_exists( 'msa_taxonomy_terms' ) ) :

	function msa_taxonomy_terms( $tax ) {

	  $terms = get_terms($tax); 
	  if ( !empty( $terms ) && !is_wp_error( $terms ) ){ 
	  $output = '<ul>'; 

	  foreach ( $terms as $term ) { 
	     $term = sanitize_term( $term, 'topic' ); 
	     $term_link = get_term_link( $term, 'topic' ); 

	      $output .= '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '&nbsp;(' . $term->count . ')' . '</a></li>'; 
	  } 
	  $output .= '</ul>';
	  }

		return $output;
	}

endif;