
<?php get_header(); ?>

	<div id="category-bar" class="grid-100">
		<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	</div>

	<section id="main-section" class="grid-65 page mobile-grid-100">
		
		<?php if ( have_posts() ) :
			while ( have_posts() ) : the_post(); ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php if(has_post_thumbnail())
						the_post_thumbnail('single-thumb', array('class' => 'thumbnail full-width medium-height-limit'));
					else
						echo "<img class='thumbnail full-width medium-height-limit' src='".get_template_directory_uri()."/images/nothumb.jpg' />"; ?>
				</a>
	    		<div class="grid-100 title">
					<h3><?php the_title(); ?></h3>
				</div>
				
				<p><?php the_time('F j, Y') ?> | <?php the_category(', ') ?> | <?php the_author() ?> | <a href="<?php comments_link(); ?>"> <?php comments_number ('0','1','%'); ?> Comments</a></p>
				
				<div class="blog1ent-entry">
					<p><?php the_content(); ?></p>
				</div>
				
	  		<?php endwhile; ?>
	  		
	  		<div class="clear"></div>
	  		
	  		<?php comments_template();
	  	else: ?>
     		<p><?php 'No posts by this author.'; ?></p>
		<?php endif; ?>
		
	</section>
	
<?php get_footer(); ?>
