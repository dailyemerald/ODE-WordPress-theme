<?php get_header(); ?>

<div id="container">
	<div id="content" role="main">

	<?php if ( have_posts() ) : ?>
		
	<?php
		global $wp_query, $ode;
		$search_array = explode( ' ', get_search_query() );
	?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class('article-list-tease'); ?>>
			<?php
				$high_title = new Highlighter( $post->post_title, $search_array );
				$high_title->mark_words();		
			?>
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo $high_title->get(); ?></a></h3>

			<div class="entry-meta">
				<span class="author"><?php ode_author_posts_link(); ?></span> - <span class="timestamp"><?php ode_timestamp(); ?></span>
			</div><!-- .entry-meta -->

			<div class="entry-summary entry">
				<?php
					$high_content = new Highlighter( $post->post_content, $search_array );
					$high_content->text = $high_content->strip( $high_content->text );
					$high_content->zoom( 10, 175 );
					$high_content->mark_words();
				?>
				<?php echo $high_content->get(); ?>
			</div>

			<div style="clear:both"></div>

			<!-- .entry-summary -->

		</div><!-- #post-## -->

	<?php endwhile; // End the loop. Whew. ?>
	
	<?php /* Display navigation to next/previous pages when applicable */ ?>
	<?php if (  $wp_query->max_num_pages > 1 ) : ?>
		<div id="nav-below" class="navigation">
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
		</div><!-- #nav-below -->
	<?php endif; ?>			
			
	<?php else: ?>
		
		<div id="post-0" class="post error404 not-found">
			<h1 class="entry-title"><?php _e( 'Not Found', 'twentyten' ); ?></h1>
			<div class="entry-content">
				<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</div><!-- #post-0 -->
		
	<?php endif; ?>

	</div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>