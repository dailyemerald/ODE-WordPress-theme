<?php get_header(); ?>

<div id="container">
	<div id="content" role="main">

	<?php get_template_part( 'loop', 'single' ); ?>

	</div><!-- #content -->
</div><!-- #container -->

<?php 
// don't show the sidebar if the post is a multimedia post
if (in_category('multimedia')) {
	//nothing
} else {	
	get_sidebar(); 
}	

get_footer();

?>


