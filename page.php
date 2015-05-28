<?php get_header(); ?>

	<div id="category-bar" class="grid-100 mobile-grid-100">
		<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	</div>

	<section id="main-section" class="grid-65 page">
		<div class="grid-100 title">
			<h3><?php the_title(); ?></h3>
		</div>
		<div class="grid-100">
			<?php if ( have_posts() ) :
				while ( have_posts() ) : the_post(); ?>
					<div>
						<p><?php the_content(); ?></p>
					</div>
				<?php endwhile; 
			endif; ?>
		</div>
	</section>

<?php get_footer(); ?>
