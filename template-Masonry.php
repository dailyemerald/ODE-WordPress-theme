<?php
/*
Template Name: Masonry front (IV)
*/
get_header(); 
?>

		
		<style text="text/css">
		#wrapper {
			width: 100%;
		}
		#main {
			width: 100%;
		}
		#container {
			width: 100%;
		}
		#content {
			/*width: 100%;*/
		}

		#content .masonry-article-wrapper {
			width: 200px;
			font-size: 13px;
			line-height: 14px;
			margin: 6px;	
		}
		
		#content .masonry-article {
			border-left: 1px solid #004F27;
			padding-left: 6px;
			padding-right: 6px;
		}
		#content .masonry-article h2 {
			font-size: 17px;
			line-height: 19px;
		}
		#content .masonry-article p {
			margin: 0;
		}
		#content .masonry-article-header, #content .masonry-article-header a {
			text-transform: uppercase;
			font-size: 10px;
			font-family: Helvetica;
			color: #666;
		}
		#content.masoned, #content.masoned.masonry-article-wrapper {
		  -webkit-transition: all .7s ease-out;
			 -moz-transition: all .7s ease-out;
			   -o-transition: all .7s ease-out;
				  transition: all .7s ease-out;
		}
		</style>

		<div id="container">
			<div id="content" role="main">

			<?php
					$wp_query = new WP_Query('showposts=60');
					while ($wp_query->have_posts()) : $wp_query->the_post(); 
			?>


			<div class="masonry-article-wrapper">
				<div class="masonry-article-header"><?php //get_the_category()[0]; ?></div>
				<div class="masonry-article">			  
					<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( array(200,300) ); ?></a>
					<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<?php the_time('g:i a');?> &mdash; <?php the_time('F j, Y'); ?>
					<?php the_excerpt(); ?>
				</div>
			</div>

			<?php endwhile; ?>
			
				
			</div><!-- #content -->
		</div><!-- #container -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
		<script type="text/javascript" src="/wp-content/themes/ode/js/jquery.masonry.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$('#content').masonry({ singleMode: true });
		});
		</script>


<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php 
/*
<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<h6 class="byline" style="display: inline">By <span class="article-tease-author"><?php the_author(); ?></span></h2>
<?php iv_timeago(); ?>
*/ 
				