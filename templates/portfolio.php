	<div class="portfolio">
	<?php 

/**
 * Fetch the terms for the types
 */
$terms = get_terms( 'types', array(
	'orderby'    => 'title',
	'order'      => 'DESC'
) );
?>
	<?php
/**
 * Run a query for each type
 */
foreach( $terms as $term ) {

/**
 * Define the query
 */ 
	$args = array(
		'posts_per_page' => '-1',
		'post_type' => 'suesdesign_portfolio',
		'types' => $term->slug
	);
	$query = new WP_Query( $args );
	$term_name = $term->name;
	$term_slug = $term->slug;
	$class_name = $term_slug . '-portfolio';

/**
 * Output the term name in a heading tag
 */             
	echo'<h2>' . $term_name . '</h2>';
	?>

	<div class="<?php echo $class_name; ?>">
	 
	<?php

/**
 * Output the post titles in a list
 */
	
/**
 * Start the Loop
 */ 
		while ( $query->have_posts() ) : $query->the_post(); ?>

		<div class="<?php echo $term_slug; ?>">
		
			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
				<?php the_post_thumbnail('medium'); ?>
				<p><?php the_title(); ?></p>
			</a>
		</div>

		<?php endwhile;

/**
 * Use reset postdata to restore orginal query
 */
	wp_reset_postdata(); ?>
	</div>

<?php } ?>
