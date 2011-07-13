<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE HTML>
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

<?php if (has_post_thumbnail()) { ?>
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

<div id="fb-root"></div>
<script type="text/javascript"> 
	window.fbAsyncInit = function() {
		FB.init({appId: '197312536953017', status: true, cookie: true, xfbml: true});
	};
	(function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	}());
</script>


<!-- ATTACHED TIMEAGO JS FOR RELATIVE TIMESTAMPS. TODO: ADD TO EXTERNAL JS FILE -->
<script type="text/javascript">
//jQuery(document).ready(function() {
//  jQuery("time.timeago").timeago();
//});
</script>
<!-- END TIMEAGO -->

<!-- ****************** -->
<!-- START ADGEAR SETUP -->
<script type="text/javascript" language="JavaScript">
CPN_PARTNER = "false";
(function() {
var _r = Math.floor(Math.random()*1000000);
if (_r < 300000) {
CPN_PARTNER = "true";
}
})();
</script>
<script type="text/javascript" language="JavaScript">
/*
<![CDATA[
*/
(function() {
  var proto = "http:";
  var host = "cdn.adgear.com";
  var bucket = "a";
  if (window.location.protocol == "https:") {
    proto = "https:";
    host = "a.adgear.com";
    bucket = "";
  }
  document.writeln('<scr' + 'ipt type="text/ja' + 'vascr' + 'ipt" s' + 'rc="' +
      proto + '//' + host + '/' + bucket + '/adgear.js/current/adgear.js' +
      '"></scr' + 'ipt>');
})();
/*
]]>
*/
</script>
<script type="text/javascript" language="JavaScript">
/*
<![CDATA[
*/
  ADGEAR.tags.script.init();
  ADGEAR.lang.namespace("ADGEAR.site_callbacks");
  ADGEAR.site_callbacks.variables = function() {
    return { };
  }
/*
]]>
*/
</script>
<script type="text/javascript" language="JavaScript">
ADGEAR.site_callbacks.variables = function() {
return { "CPN_PARTNER": CPN_PARTNER }; }
</script>
<!-- End Ad Gear Header -->
<!-- Ad script and Report Header 041911 -->
<script type="text/javascript">
var anCPCd = "WP";
var anCPPipe = "1";
var anCPPaperId = "859";
var anCPPaperName = "Oregon Daily Emerald";
var anCPPaperUrl = location.host;
</script>
<script type="text/javascript">
var adGearSeg_Format_id="";
var adGearSeg_ChipKey="";
var adGearSeg_ContainerID="";
var adGearSeg_path="";
var adGearSeg_adPaperID= anCPPaperId;
var adGearSeg_Section="";
var adGearSeg_Zone=adGearSeg_Section;
var adGearSeg_div=",";
var papername=anCPPaperName;
</script>
<script type="text/javascript" src="/wp-content/themes/ode/js/adGearSegmentation.js"></script>
<script type="text/javascript">getAdGearCMNSections(adGearSeg_adPaperID);</script>
<!-- END ADGEAR SETUP -->
<!-- **************** -->

</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
	<div id="header">
		
		<div id="header-bar">
			<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'header' ) ); ?>
		</div>
		
		<div id="masthead">
			<div id="branding" role="banner" style="float:left;">
				<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				<<?php echo $heading_tag; ?> id="site-title">
					<span>
						<!--<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>-->
						<a href="/"><img src="/wp-content/themes/ode/images/emerald-flag.png"></img></a>
					</span>
				</<?php echo $heading_tag; ?>>
				<div id="branding-right">
					
				</div>
			</div><!-- #branding -->

			<div id="access" role="navigation">
			  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a></div>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
				
				<div class="site-search"><?php get_search_form(); ?></div>
			</div><!-- #access -->
			
			<div style="clear:both"></div>
			
			<div id="top-banner-ad-wrapper">
				<!-- Main Banner Ad -->
				<div id="top-banner-ad">
					<?php adtag_banner(); ?>	
				</div>
			</div>
			
		</div><!-- #masthead -->

	</div><!-- #header -->

	<div id="main">