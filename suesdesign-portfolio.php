<?php
/**
 * @package Suesdesign portfolio
 * @version 1.0
 */
/*
Plugin Name: Suesdesign portfolio
Plugin URI: http://suesdesign.co.uk/
Description: Portfolio
Author: Sue Johnson
Version: 1.0
Author URI: http://suesdesign.co.uk/
*/

/*
 * Register custom post type
*/
add_action( 'init', 'suesdesign_register_post' );

/**
 * Create custom post type
 * @return type
 */
function suesdesign_register_post() {
	$labels = array( 
		'name'               => _x( 'Portfolio', 'suesdesign_portfolio' ),
		'singular name'      => _x( 'Portfolio piece', 'suesdesign_portfolio' ),
		'add_new'            => _x( 'Add new portfolio piece', 'suesdesign_portfolio' ),
		'add_new_item'       => __( 'Add new portfolio piece', 'suesdesign_portfolio' ),
		'new_item'           => __( 'New portfolio piece', 'suesdesign_portfolio' ),
		'edit_item'          => __( 'Edit portfolio piece', 'suesdesign_portfolio' ),
		'view_item'          => __( 'View portfolio piece', 'suesdesign_portfolio' ),
		'all_items'          => __( 'All portfolio pieces', 'suesdesign_portfolio' ),
		'search_items'       => __( 'Search portfolio pieces', 'suesdesign_portfolio' ),
		'not_found'          => __( 'No portfolio pieces', 'suesdesign_portfolio' ),
		'not_found_in_trash' => __( 'No portfolio pieces found in trash' ),
	);

	$args = array(
		'labels'      => $labels,
		'public'      => true,
		'has archive' => true,
		'supports'    => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'     => array( 'slug' => __( 'portfolio' ))
	);
	
	register_post_type( 'suesdesign_portfolio', $args );
	}

/*
 * Check to see if the template exists in the theme otherwise select the template from the plugin
*/	
add_filter( 'template_include', 'suesdesign_template', 1 );

/**
 * Check to see if the template exists in the theme otherwise select the template from the plugin
 * @param type $template_path 
 * @return type
 */
function suesdesign_template( $template_path ) {

	if ( is_singular( 'suesdesign_portfolio' ) ) {
		if ( $theme_file = locate_template( array ( 'single-suesdesign_portfolio.php' ) ) ) {
				$template_path = $theme_file;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) . '/templates/single-suesdesign_portfolio.php';
			}
	}
   
	return $template_path;
}

/**
* Sidebar
*/

/**
 * Register widgetized areas
 * @return type
 */
function suesdesign__portfolio_widgets_init() {

register_sidebar( array(
		'name'          => __( 'Portfolio', 'suesdesign_portfolio' ),
		'id'            => 'portfolio',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );

}
add_action( 'widgets_init', 'suesdesign__portfolio_widgets_init' );

/*
** Custom widget to display suesdesign_portfolio posts
*/
class Suesdesign_Widget extends WP_Widget {

/**
 * Sets up the widgets name etc
 */
	public function __construct() {
		$suesdesign_widget = array( 
			'classname' => 'portfolio-widget',
			'description' => 'Suesdesign portfolio widget',
		);
		parent::__construct( 'suesdesign_portfolio_widget', 'Portfolio Widget', 'suesdesign_widget' );
	}

/**
 * Outputs the content of the widget
 *
 * @param array $args
 * @param array $instance
 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];

?>

<?php
/*
** Get the terms
*/
$terms = get_terms( 'types', array(
	'orderby'    => 'count',
	'order'      => 'DESC'
) );

/*
** Run a query for each term
*/
foreach( $terms as $term ) {

	// Define the query
	$terms_args = array(
		'posts_per_page' => '-1',
		'post_type' => 'suesdesign_portfolio',
		'types' => $term->slug
	);
	$query = new WP_Query( $terms_args );

	// output the term name in a heading tag                
	echo'<h3>' . $term->name . '</h3>';

	// output the post titles in a list
	echo '<ul>';

	// Start the Loop
		while ( $query->have_posts() ) : $query->the_post(); ?>

		<li class="portfolio-listing <?php //$item = the_title();
		$post_title = get_queried_object()->post_title;
		$title_menu = get_the_title();
		if ($post_title === $title_menu) {
			echo 'current-item';
		} ?>" id="post-<?php the_ID(); ?>"
		
		>
		
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</li>

		<?php endwhile;

	echo '</ul>';

	wp_reset_postdata();

} ?>

<?php echo $args['after_widget'];

}

/**
 * Outputs the options form on admin
 *
 * @param array $instance The widget options
 */
	public function form( $instance ) {
		// outputs the options form on admin
		if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
	} else {
	$title = __( 'Portfolio', 'suesdesign_widget' );
	}// Widget admin form
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php
	
	}

/**
 * Processing widget options on save
 *
 * @param array $new_instance The new options
 * @param array $old_instance The previous options
 */
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	return $instance;
	}
} // Class wpb_widget ends here

function register_suesdesign_widget() {
    register_widget( 'suesdesign_widget' );
}
add_action( 'widgets_init', 'register_suesdesign_widget' );

/*
** Create custom taxonomy
*/
// hook into the init action and call suesdesign_create_taxonomy when it fires

add_action( 'init', 'suesdesign_create_taxonomy', 0 );

/**
 * Create taxonomy
 * @return type
 */
function suesdesign_create_taxonomy() {

// Labels part for the GUI

  $labels = array(
    'name' => _x( 'types', 'taxonomy general name' ),
    'singular_name' => _x( 'Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search types' ),
    'popular_items' => __( 'Popular types' ),
    'all_items' => __( 'All types' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Type' ), 
    'update_item' => __( 'Update Type' ),
    'add_new_item' => __( 'Add New Type' ),
    'new_item_name' => __( 'New Type Name' ),
    'separate_items_with_commas' => __( 'Separate types with commas' ),
    'add_or_remove_items' => __( 'Add or remove types' ),
    'choose_from_most_used' => __( 'Choose from the most used types' ),
    'menu_name' => __( 'Types' ),
  ); 

// Register the taxonomy

  register_taxonomy( 'types','suesdesign_portfolio', array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type' ),
  ));
}


/**
 * Create a shortcode for the poertfolio
 * @return type
 */
function suesdesign_portfolio_shortcode(){
// Buffer the output so it doesn't appear at the top of the page
	ob_start();
	$portfolio_template_path = plugin_dir_path( __FILE__ ) . '/templates/portfolio.php';
	
	include_once $portfolio_template_path;
	return ob_get_clean();
};

function suesdesign_register_shortcodes(){
   add_shortcode( 'portfolio', 'suesdesign_portfolio_shortcode' );
};

add_action( 'init', 'suesdesign_register_shortcodes' );

/*
** Single portfolio items shortcode
*/
function suesdesign_portfolio_piece_shortcode( $atts, $content = null ) {
	return '<div class="portfolio-piece">' . $content . '</div>';
}
add_shortcode( 'portfolio-piece', 'suesdesign_portfolio_piece_shortcode' );

