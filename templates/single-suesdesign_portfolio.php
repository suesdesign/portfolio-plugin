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

		if( has_term('design', 'types' ) ){
			$portfolio_class = 'design-single';
		} else {
		$portfolio_class = 'websites-single';
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
*** Suesdesign Portfolio 1.0 ***
*   sidebar
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