<?php get_header(); ?>

	<div id="category-bar" class="grid-100 mobile-grid-100">
		<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	</div>

	<section id="main-section" class="grid-65 page">
		<div class="grid-100 title">
			<h3>Error 404</h3>
		</div>
	<div class="grid-100">
		<div class="bg-oo">
			<div class="cate-oops">Oops, article does not exist!</div>
			<div class="cate-aeros">Sorry for the inconvenience but there is nothing here..</div>
		</div>
	</div>

<?php get_footer(); ?>
