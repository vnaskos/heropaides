<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
	<!--[if lt IE 9]>
		<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/html5.js"></script>
	<![endif]-->

	<!--[if (gt IE 8) | (IEMobile)]><!-->
		<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/unsemantic-grid-responsive.css" />
	<!--<![endif]-->
	<!--[if (lt IE 9) & (!IEMobile)]>
		<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/ie.css" />
	<![endif]-->

	<?php wp_head(); ?>
</head>
<body>
	<div id="wrap" class="grid-container">
		<header id="top-header">
			<div id="logo" class="grid-40 mobile-grid-100">
				<a class="hide-on-mobile" href="<?php echo esc_url(home_url()) ?>">
					<?php
					$logo_image = get_option(SHORT_NAME . 'logo-image');
					
					if($logo_image == "")
						echo '<img src="'.get_template_directory_uri().'/images/logo.jpg" />';
					else
						echo '<img src="'.$logo_image.'" />';
					?>
				</a>
				<a class="hide-on-desktop" href="<?php echo esc_url(home_url()) ?>">
					<?php
					$logo_image_mobile = get_option(SHORT_NAME . 'logo-image-mobile');
					
					if($logo_image_mobile == "")
						echo '<img src="'.get_template_directory_uri().'/images/logo-mobile.png" />';
					else
						echo '<img src="'.$logo_image_mobile.'" />';
					?>
				</a>
			</div>	
			<nav id="main-menu" class="grid-55 push-5 mobile-grid-100" >
				<div class="menu-button">Menu</div>
				<div class="flexnav" data-breakpoint="800">
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</div>
			</nav>
		</header>

