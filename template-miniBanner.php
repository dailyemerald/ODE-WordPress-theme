<?php
/*
Template Name: MiniBanner (IV)
*/
get_header(); 

?>
<style type="text/css">
#content {
	width: 960px;
}

#content .m-tease {
	margin: 5px;
	padding: 5px;
	border-bottom: 1px solid #666;
}
#content .m-tease-header {
	text-transform: uppercase;
	font-size: 12px;
	font-family: Helvetica;
	color: #666;
}
#content .m-tease-title {
	font-size: 24px;
}
#content .m-tease-image {
	float: left;
	margin-top: 5px;
	margin-right: 5px;
}
#content .m-tease-excerpt-img {
	padding-top: 5px;
	margin-top: 0;
	margin-left: 166px;
	margin-bottom: -13px;
}
#content .m-tease-excerpt-noimg {
	padding-top: 5px;
	margin-top: 0;
	margin-left: 0;
	margin-bottom: -13px;
}
</style>


		<div id="container">
			<div id="content" role="main">

			<?php
			$mobile_query = new WP_Query('posts_per_page=30');			
			while ( $mobile_query->have_posts() ) : $mobile_query->the_post(); 
			?>
			
			<div class="m-tease">
				<span class="m-tease-header"><?php the_category(' // '); ?> &mdash; <strong><?php the_time('g:i a');?></strong> &mdash; <?php the_time('F j, Y'); ?></span><br>
				<span class="m-tease-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span><br>
				<?php if (has_post_thumbnail()) { ?>
					<div class="m-tease-image"><?php the_post_thumbnail(array(150,100)); ?></div>
					<div class="m-tease-excerpt-img"><?php the_excerpt(); ?></div>
				<?php } else { ?>
					<div class="m-tease-excerpt-noimg"><?php the_excerpt(); ?></div>					
				<?php } ?>
				<div style="clear:both"></div>
			</div>
			
			
			<?php // close up the Loop	
			endwhile;
			wp_reset_postdata();
			?>
	
				
				
			</div><!-- #content -->
		</div><!-- #container -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
