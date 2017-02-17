<?php
/*
*** Suesdesign Starter Theme 1.0 ***
*/
?>

<?php get_header(); ?>

	<main id="maincontent" class="column2">

	<h1>Portfolio single inplugin piece</h1>

	<?php if ( have_posts () ) : while (have_posts()) : the_post(); ?>

<?php
/**
 * get the current taxonomy term
 */
	$terms = get_the_terms( $post->ID, 'types' );
	if ( !empty( $terms ) ){
		// get the first term
		$term = array_shift( $terms );
		$portfolio_class = $term->name;
		$portfolio_class .= '-single';
		echo $portfolio_class;
	}
?>
		
	<article class="page" id="post-<?php the_ID(); ?>">
		<header>
			<h1 class="entry-title">
				<?php the_title(); ?>
			</h1>
		</header>
		<div class="<?php echo $portfolio_class ?>">
			<?php the_content() ?>
		</div><!--.entry-->
	</article><!-- finish enclosing post--> 
      
	<?php endwhile; wp_reset_query(); ?>
	<?php else : endif;?>

	</main>

	<?php
/*
** sidebar ***
*/
?>

<div class="column1" id="portfolio">
	<aside>
<?php
	if ( is_active_sidebar( 'portfolio' ) ) : ?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'portfolio' ); ?>
	</div><!-- #secondary -->
<?php endif; ?>
</aside>
</div><!--.column1-->

<?php get_footer();?>