<div class="primary-search">
	<?php get_search_form(); ?>
</div><!-- .primary-search -->

<?php if ( have_posts() ) : ?>
	
<?php
	global $wp_query, $ode;
	$search_array = explode( ' ', get_search_query() );
	foreach( $search_array as $key => $term ) {
		if ( strlen( $term ) < 4 )
			unset( $search_array[$key] );
	}
?>

<?php while ( have_posts() ) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class('article-list-tease'); ?>>
		<?php
			$high_title = new Highlighter( $post->post_title, $search_array );
			$high_title->mark_words();		
		?>
		<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo $high_title->get(); ?></a></h3>

		<div class="entry-meta">
			<?php
				$high_author = new Highlighter( ode_get_author_posts_link(), $search_array );
				$high_author->mark_words();
			?>
			By <span class="author"><?php echo $high_author->get(); ?></span> - <span class="timestamp"><?php do_action( 'ode_timestamp' ); ?></span>
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

<?php do_action( 'ode_pagination' ); ?>		
		
<?php else: ?>
	
	<div class="message info">Sorry, no results have been found for this query</div>
	
<?php endif; ?>