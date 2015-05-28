<?php

define("SHORT_NAME", "hero_paides_");
define("THEME_NAME", "HeroPaides");
$cp_options;

function theme_setup() {

	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'index-thumb', 955, 360, true );
		add_image_size( 'index2-thumb', 210, 160, true );
		add_image_size( 'index3-thumb', 160, 160, true );
		add_image_size( 'single-thumb', 662, 225, true );
	}
	
	register_nav_menu('primary', 'Primary Navigation');
	
	if ( function_exists('register_sidebar') )
		register_sidebar(array(
								'name' => 'Home-Sidebar-Widgets',
								'before_widget' => '<div class="widget">',
								'after_widget' => '</div>',
								'before_title' => '<h2>',
								'after_title' => '</h2>'
								));

	if ( function_exists('register_sidebar') )
		register_sidebar(array(
								'name' => 'Footer-Widgets',
								'before_widget' => '<div class="footer-widget">',
								'after_widget' => '</div>',
								'before_title' => '<h3>',
								'after_title' => '</h3>',
								));

}

add_action( 'after_setup_theme', 'theme_setup' );

function theme_scripts() {
	$template_dir = get_template_directory_uri();
	
	wp_enqueue_style( 'main-style', $template_dir.'/css/default.css' );
	wp_enqueue_style( 'flexnav-style', $template_dir.'/css/flexnav.css' );
	
	
	wp_enqueue_script("flexnav", $template_dir."/js/jquery.flexnav.min.js", array('jquery'));
	wp_enqueue_script("slideshow", $template_dir."/js/responsiveslides.min.js", array('jquery'));
	wp_enqueue_script("general", $template_dir."/js/general.js", array('jquery'), '1.0.0', true);
	
	/*if(is_admin()) {
		wp_enqueue_style( 'control-panel', get_template_directory_uri()."/css/cp.css", false, "1.0", "all" );
	}*/
}

add_action( 'wp_enqueue_scripts', 'theme_scripts');

function admin_style_init() {
	wp_enqueue_style( 'control-panel', get_template_directory_uri()."/css/cp.css", false, "1.0", "all" );
}

add_action( 'admin_init', 'admin_style_init' );

function the_content_limit($max_char) {
	$more_link_text = " ...";
	$stripteaser = 0;
	
	$content = get_the_content($more_link_text, $stripteaser, "");
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

	if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
		$content = substr($content, 0, $espacio);
		$content = $content.$more_link_text;
	}
	echo "<p>".$content."</p>";
}

function WP_Control_Panel($options) {
	
	global $cp_options;
	
	if (! is_array($options)) {
		die("Expects an array");
	}
	
	if (empty($options)) {
		die("Array cannot be empty");
	}
	
	for ($i = 0; $i < count($options); $i++) {
		if(array_key_exists('id', $options[$i])) {
			$options[$i]['id'] = SHORT_NAME . $options[$i]['id'];
		}
	}
	
	$cp_options = $options;
	
	foreach($cp_options as $option) {
		if ((array_key_exists('id', $option) === true) && (get_option($option['id']) === false)) {
			add_option($option['id'], $option['std']);
		}
	}
}

function add_menu() {
	global $cp_options;
	
	if(isset($_GET['page'])):
		if ($_GET['page'] == basename(__FILE__)) {
		
			if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'save') {
		
				foreach ($cp_options as $option) {
					update_option($option['id'], stripslashes($_REQUEST[$option['id']]));
				}
			
				header("Location: themes.php?page=functions.php&saved=true");
				die;
			}			
		}
	endif;
	
	add_menu_page(THEME_NAME . ' Theme Control Panel', 'Theme CP', 'administrator', basename(__FILE__), 'show_cp_page');
}
	
function show_cp_page() {
	
	global $cp_options;
		
	if (isset($_REQUEST['saved']) && $_REQUEST['saved'] == true) {
		echo '<div class="updated fade" id="message"><p><strong>'.THEME_NAME.' Theme Settings Saved.</strong></p></div>';
	} ?>
		
	<div class="theme-settings">
		<h2><?php echo THEME_NAME; ?> Settings</h2>
		<div class="description">To easily customize the <?php echo THEME_NAME;?> theme, you can use the menu below.</div>
		
		<form action="" method="post">
			<fieldset>
			<?php foreach ($cp_options as $option):
		
				switch ($option['type']) {
				
					case "title": ?>		
						<div class="title">
							<h3><?php echo $option['name']; ?></h3>
							<input id="submit" name="save" type="submit" value="Save changes" />
							<input type="hidden" name="action" id="action" value="save" />
						</div>
						<?php break;
						
					case "text": ?>		
		        		<div class="fieldset-item">
							<label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label>
							<input class="textfield" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" type="<?php echo $option['type']; ?>" 
								value="<?php if (get_option($option['id']) != '') { echo get_option($option['id']); } else { echo $option['std']; }?>" />
							<small><?php echo $option['desc']; ?></small>
						</div>
						<?php break;
						
					case "textarea": ?>
						<div class="fieldset-item">
							<label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label>
							<textarea class="textarea" name="<?php echo $option['id']; ?>" type="<?php echo $option['type']; ?>"><?php
								if (get_option($option['id']) != "") {
									echo get_option($option['id']);
								} else {
									echo $option['std'];
								}
							?></textarea>
							<small><?php echo $option['desc']; ?></small>
						</div>
						<?php break;
						
					case "select": ?>
		        		<div class="fieldset-item">
							<label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label>
							<select class="textfield" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>">
								<?php foreach ($option['options'] as $op) { ?>
									<option <?php if ($op == get_option($option['id']) || $op == $option['std']) { echo 'selected="selected"'; } ?>><?php echo $op; ?></option>
								<?php } ?>
							</select>
							<small><?php echo $option['desc']; ?></small>
						</div>
						<?php break;
						
					case "selectcat": ?>
						<div class="fieldset-item">
							<label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label>
								<?php
								$old = get_option($option['id']) === false ? '-1' : get_option($option['id']);
								$args = array(	'depth' => 0,
												'hierarchical' => 1,
												'hide_empty' => 0,
												'name' => $option['id'],
												'class' => 'textfield',
												'selected' => $old,
												'show_option_none' => 'No category selected');
								wp_dropdown_categories($args);
								?>
							<small><?php echo $option['desc']; ?></small>
						</div>
						<?php break;
						
					case "checkbox": ?>
						<div class="fieldset-item">
							<label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label>
							<?php $checked = '';
							if (get_option($option['id']) == 'true' || (get_option($option['id']) === false && $option['std'] == 'true')) { $checked = 'checked'; } ?>
							<input class="checkbox" type="checkbox" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" value="true" <?php echo $checked; ?> />
							<small><?php echo $option['desc']; ?></small>
						</div>
						<?php break;
				}
			endforeach;	?>
			</fieldset>
		</form>
	</div>
<?php
}

/**********************************************************************/
/*
/*	class WP_Control_Panel
/*	ends here
/*
/**********************************************************************/

$options = array(
			array( "name" => "Theme Layout",
				"type" => "title"),
			array(	"name" => "Logo Image",
				"desc" => "Enter the full URL of your custom logo image here.",
				"id" => "logo-image",
				"type" => "text",
				"std" => ""),
			array(	"name" => "Logo Image Mobile",
				"desc" => "Enter the full URL of your custom logo image here. Note: Only shown on mobile devices.",
				"id" => "logo-image-mobile",
				"type" => "text",
				"std" => ""),
			array( "name" => "Homepage Slider Settings",
				"type" => "title"),
			array( "name" => "Category for Slider",
				"desc" => "Select a category for Homepages Slider Images",
				"id" => "slideshow-cat",
				"type" => "selectcat",
				"std" => "-1"),	
			array(	"name" => "Number of slideshow posts",
				"desc" => "Enter the total number of posts in slideshow.",
				"id" => "slideshow-posts-counter",
				"type" => "text",
				"std" => "5"),
			array( "name" => "Disable Sliding Gallery on Homepage",
				"desc" => "Check this box if you want to disable Sliding Gallery on Homepage Layout.",
				"id" => "slideshow-disable",
				"type" => "checkbox",
				"std" => ""),				
			array( "name" => "Middle Section Settings for Homepage",
				"type" => "title"),		
			array( "name" => "Teaser Text Below Slider",
				"desc" => "Enter the teaser heading text for the hompage here",
				"id"   => "teaser-text",
				"type" => "textarea",
				"std" =>  "The best blog in the city. Now with heroic style."),
			array( "name" => "Teaser Small Text Below Slider",
				"desc" => "Enter the teaser small text for the hompage here",
				"id"   => "teaser-text-small",
				"type" => "textarea",
				"std" =>  "Relax and enjoy your visit!"),
			array( "name" => "Disable Teasers Text on Homepage",
				"desc" => "Check this box if you want to disable Teasers Text.",
				"id" => "teaser-disable",
				"type" => "checkbox",
				"std" => ""),			
			array( "name" => "Featured Posts Text on Left",
				"desc" => "Enter the featured post heading text for the hompage left section.",
				"id"   => "featured-posts-text",
				"type" => "textarea",
				"std" =>  "Latest posts"),
			array( "name" => "Featured Posts Small Text on Left",
				"desc" => "Enter the featured post small text for the hompage left section.",
				"id"   => "featured-posts-subtext",
				"type" => "textarea",
				"std" =>  "Most popular, most interesting and fresh news and articles!"),
			array( "name" => "Featured Posts Link Code on Left",
				"desc" => "Enter the featured post URL link code, see documentation for code.",
				"id"   => "featured-posts-link",
				"type" => "textarea",
				"std" =>  "<a href='#'>Link URL Code</a>"),
			array( "name" => "Featured Posts",
				"desc" => "Select a category for featured posts ( which is in the middle section ) on your homepage.",
				"id" => "category_1",
				"type" => "selectcat",
				"std" => "-1"),
			array( "name" => "Disable Featured Posts on Homepage",
				"desc" => "Check this box if you want to disable featured posts, which is on Homepage middle section.",
				"id" => "featured-posts-disable",
				"type" => "checkbox",
				"std" => ""),
			array( "name" => "Footer Settings",
				"type" => "title"),	
			array( "name" => "Disable Footer Widgets Section",
				"desc" => "Check this box if you want to disable Footer widgets section.",
				"id" => "footer-widgets",
				"type" => "checkbox",
				"std" => ""),	
			array( "name" => "Footer Text",
				"desc" => "Enter footer copyright text or links",
				"id"   => "footer-text",
				"type" => "textarea",
				"std" =>  "Copyright 2013")						

			);

WP_Control_Panel($options);

add_action('admin_menu', 'add_menu');

function print_emp_feat($cat_id) { ?>
	<div class="ftbox">
		<div class="title"></div>
		<div class="fpostbox">
			<div class="fpost-content">
				<?php if ($cat_id < 0) { ?>
					<div class="fpost-title"><a href="" rel="bookmark" title="No category selected">No category selected</a></div>
				<?php } else { ?>
					<div class="fpost-title"><a href="<?php echo get_category_link($cat_id); ?>" rel="bookmark" title="Permanent Link to ">No posts in <?php echo get_cat_name($cat_id); ?> category</a></div>
				<?php }?>
			</div>
		</div>
	</div>
<?php
}

// remove menu container div
function my_wp_nav_menu_args( $args = '' ) {
    $args['container'] = false;
    return $args;
}

add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );


function print_emp_cat($cat_num, $cat_id) { ?>
	<div class="cat<?php echo $cat_num; ?>-box">
		<div class="cat<?php echo $cat_num; ?>-head">
			<div class="cat<?php echo $cat_num; ?>-head-title">
				<?php if ($cat_id < 0) { ?>
					<a href="" rel="category">No selected category</a>
				<?php } else { ?>
					<a href="<?php echo get_category_link($cat_id); ?>" rel="category">No article in category <?php echo get_cat_name($cat_id); ?></a>
				<?php } ?>
			</div>
		</div>
		
		<div class="cat<?php echo $cat_num; ?>-content"></div>
	</div>
<?php }

	
/**********************Meta Box Ends Here*******************************/


function dimox_breadcrumbs() {
 
  $delimiter = '&raquo;';
  $home = 'Home'; // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="crumbs">';
 
    global $post;
    $homeLink = home_url();
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . 'Category "' . single_cat_title('', false) . '"' . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Posts of ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo 'Page ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
 
  }
} // end dimox_breadcrumbs()

?>
