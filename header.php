<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" <?php //language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>	



<meta property="fb:admins" content="100001785043323" />
<meta property="fb:app_id" content="197312536953017" />
<meta property="og:url" content="<?php the_permalink() ?>"/>
<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />

<?php if (is_single()) { ?>
<meta property="og:title" content="<?php single_post_title(''); ?>" />
<meta property="og:description" content="<?php echo strip_tags(get_the_excerpt($post->ID)); ?>" />
<meta property="og:type" content="article" />

<?php if ( has_post_thumbnail() ) { ?>
<meta property="og:image" content="<?php echo wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) ) ?>" />
<?php } else { ?>
<meta property="og:image" content="http://www.dailyemerald.com/assets/e-sq.jpg" />
<?php } ?>

<meta name="description" content="<?php echo strip_tags(get_the_excerpt($post->ID)); ?>" />

<?php } else { ?>
<meta name="description" content="<?php bloginfo('description'); ?>" />
<meta property="og:description" content="<?php bloginfo('description'); ?>" />
<meta property="og:type" content="website" />
<meta property="og:image" content="http://www.dailyemerald.com/assets/e-sq.jpg" />
<?php }  ?>

<?php //keywords: $metas=''; {foreach(get_the_tags($post->ID) as $tag) { $metas .= $tag->name . ', '; } echo substr($metas,0,-2);} ?>
<meta name="google-site-verification" content="tKZ-zBCyoOqqxlUVpAKtqTpjHTQB7q98hArOIdUW2k4" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
	<div id="header">
		
		<div id="header-bar">
			<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'header' ) ); ?>
		</div>
		
		<div id="masthead">
			<div id="branding" role="banner" class="float-left">
				<div id="site-title">
					<span><a href="<?php echo home_url(); ?>"><img height="80px" width="381px" src="<?php bloginfo('template_directory'); ?>/images/emerald-flag.png"></img></a></span>
				</div>
				<div id="branding-right">
					
				</div>
			</div><!-- #branding -->

			<div id="access" role="navigation">
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a></div>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
				
				<div class="site-search"><?php get_search_form(); ?></div>
			</div><!-- #access -->
			
			<div style="clear:both"></div>
			
		</div><!-- #masthead -->

	</div><!-- #header -->

	<div id="main">