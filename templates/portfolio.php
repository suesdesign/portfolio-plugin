	<div class="websites-portfolio">
	<h2>Websites</h2>
	
	<?php 

	$websites_args = array(
		'posts_per_page' => '-1',
		'post_type' => 'suesdesign_portfolio',
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'types',
				'field'    => 'slug',
				'terms' => 'websites',
				),
			),
	);

	$suesdesign_portfolio = new WP_Query ( $websites_args );

	while ( $suesdesign_portfolio->have_posts() ) : $suesdesign_portfolio->the_post(); ?>

	<div class="websites">
		
			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
				<?php the_post_thumbnail('medium'); ?>
				<p><?php the_title(); ?></p>
			</a>
			</div>

	<?php endwhile; wp_reset_query(); ?>
	</div><!-- .websites-portfolio-->
	<div class="design-portfolio">
	<h2>Design</h2>

	<?php 

	$design_args = array(
		'posts_per_page' => '-1',
		'post_type' => 'suesdesign_portfolio',
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'types',
				'field'    => 'slug',
				'terms' => 'design',
				),
			),
	);

	$suesdesign_portfolio = new WP_Query ( $design_args );

	while ( $suesdesign_portfolio->have_posts() ) : $suesdesign_portfolio->the_post(); ?>

		
	<div class="design">
		

			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
				<?php the_post_thumbnail('medium'); ?>
				<p><?php the_title(); ?></p>
			</a>

			</div>


	<?php endwhile; wp_reset_query(); ?>
	</div><!--.design-portfolio-->
