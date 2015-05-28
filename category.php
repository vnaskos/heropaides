<?php get_header(); ?>

	<div id="category-bar" class="grid-100 mobile-grid-100">
		<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	</div>

	<section id="main-section" class="grid-65 page">
		<div class="grid-100 title">
			<h3>Category <?php single_cat_title(); ?></h3>
		</div>
		<div class="grid-100">
			<?php if ( have_posts() ) :
				while ( have_posts() ) : the_post(); ?>
					<article class="preview-box">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php if(has_post_thumbnail())
								the_post_thumbnail('single-thumb', array('class' => 'thumbnail full-width medium-height-limit'));
							else
								echo "<img class='thumbnail full-width medium-height-limit' src='".esc_url(get_template_directory_uri())."/images/nothumb.jpg' />"; ?>
						</a>
						<h2>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h2>
						<nav>
							<p><?php the_time('F j, Y') ?> | <?php the_category(', ') ?> | <?php the_author() ?> | <a href="<?php comments_link(); ?>"> <?php comments_number ('0','1','%'); ?> Comments</a></p>
						</nav>
						<div class="blog1ent-entry">
							<p> <?php the_excerpt(); ?></p>
						</div>
						<div class="read-more">
							<a href="<?php the_permalink(); ?>"title="<?php the_title(); ?>">περισσότερα &raquo;</a>
						</div>
					</article>
				<?php endwhile; ?> 
				<div class="pagination">
					<?php if(function_exists('wp_pagenavi')) { ?> <?php wp_pagenavi(); } ?>
				</div>
			<?php else : ?>
				<div class="bg-oo">
					<div class="cate-oops">Oops, an error occured.</div>
					<div class="cate-aeros">Sorry for the inconvenience but there is nothing here..</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
	
<?php get_footer(); ?>
