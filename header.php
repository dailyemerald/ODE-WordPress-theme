<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<meta name="google-site-verification" content="tKZ-zBCyoOqqxlUVpAKtqTpjHTQB7q98hArOIdUW2k4" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

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
				
				<?php if ( !is_search() ): ?>
					<div class="site-search"><?php get_search_form(); ?></div>
				<?php endif; ?>
			</div><!-- #access -->
			
			<div style="clear:both"></div>
			
		</div><!-- #masthead -->

	</div><!-- #header -->

	<div id="main">