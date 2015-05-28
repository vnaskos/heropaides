<?php get_header(); ?>		
		
		<?php
		$disable_slideshow = get_option(SHORT_NAME . 'slideshow-disable');
		if ($disable_slideshow  != "true") { ?>
			<div id="slideshow" class="grid-100 mobile-grid-100">
	            <?php
				$slideshow_cat = get_option(SHORT_NAME . 'slideshow-cat');
				$slideshow_posts_counter = get_option(SHORT_NAME . 'slideshow-posts-counter');
	
				$args = array(	'cat' => $slideshow_cat,
								'showposts' => $slideshow_posts_counter);

				$featured_query = new WP_Query($args);
				?>
				<ul class="rslides">
					<?php
					while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>" title="Permanent Link to <?php the_title(); ?>">
								<?php if(has_post_thumbnail())
									the_post_thumbnail('index-thumb');
								else
									echo "<img src='".get_template_directory_uri()."/images/nothumb-slide.jpg' />"; ?>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php } ?>
		
		<?php
		$disable_teaser = get_option(SHORT_NAME . 'teaser-disable');
		if($disable_teaser != "true") { ?>
			<div id="teaser" class="grid-100 mobile-grid-100">
				<h1><?php echo get_option(SHORT_NAME.'teaser-text'); ?></h1>
				<h2><?php echo get_option(SHORT_NAME.'teaser-text-small'); ?></h2>
			</div>
		<?php } ?>
		
		<?php 
		$disable_featured_posts = get_option(SHORT_NAME.'featured-posts-disable');
		
		if ($disable_featured_posts != "true"): ?>
			<section id="featured">
				<div class="grid-25 mobile-grid-100">
					<h3><?php echo get_option(SHORT_NAME.'featured-posts-text'); ?></h3>
					<p><?php echo get_option(SHORT_NAME.'featured-posts-subtext'); ?></p>
					<?php echo get_option(SHORT_NAME.'featured-posts-link'); ?>
				</div>
		
				<?php
				$cat1 = get_option(SHORT_NAME . 'category_1');
	
				$args = array(	'cat' => $cat1,
								'showposts' => 3);

				$recent = new WP_Query($args);
				if ($recent->have_posts() && (! ($cat1 < 0))) {
					while ($recent->have_posts()) : $recent->the_post(); ?>
						<div class="grid-25 mobile-grid-100">
							<a class="hide-on-mobile" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php if(has_post_thumbnail())
									the_post_thumbnail('index2-thumb');
								else
									echo "<img src='".get_template_directory_uri()."/images/nothumb-med.jpg' />"; ?>
							</a>
							<h3>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_title(); ?>
								</a>
							</h3>
							<p><?php the_content_limit(130); ?></p>
						</div>
			 		<?php endwhile; 
				} else {
					print_emp_cat('1', $cat1);
				} ?>
			</section>
		<?php endif ?>
		
		<section id="main-section" class="grid-65 mobile-grid-100">
			<h3><?php echo get_option(SHORT_NAME.'bleiop'); ?></h3>
			
			<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			$args = array('paged' => $paged);
			$main_query = new WP_Query($args);
			
			if ( have_posts() ) :
				while ($main_query->have_posts()) : $main_query->the_post(); ?>
					<article>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php if(has_post_thumbnail())
								the_post_thumbnail('index3-thumb', array('class' => 'thumbnail grid-25 mobile-grid-50'));
							else
								echo "<img class='thumbnail grid-25 mobile-grid-50' src='".get_template_directory_uri()."/images/nothumb-small.jpg' />"; ?>
						</a>
						
						<div class="article-content grid-75">
							<header>
								<h3>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_title(); ?>
									</a>
								</h3>
							</header>
							<nav>
								<p><?php the_time('F j, Y') ?> | <?php the_category(', ') ?> | <?php the_author() ?> | <a href="<?php comments_link(); ?>"> <?php comments_number ('0','1','%'); ?> Comments</a></p>
							</nav>
							<p><?php the_content_limit(350); ?></p>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">more</a>
					</article>
				<?php endwhile; ?>
				<div class="pagination">
					<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
				</div>
			<?php else : ?>
				<div class="bg-oo">
					<div class="cate-oops">Oops, an error occured.</div>
					<div class="cate-aeros">Sorry for the inconvenience but there is nothing here..</div>
				</div>
			<?php endif; ?>
		</section>
		
<?php get_footer(); ?>
