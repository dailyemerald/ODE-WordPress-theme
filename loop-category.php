<?php if ( have_posts() ): ?>

<?php while ( have_posts() ) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class('article-list-tease'); ?>>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<div class="entry-meta">
				<span class="byline"><?php do_action( 'ode_author_posts_link' ); ?></span> - <span class="timestamp"><?php do_action( 'ode_timestamp' ); ?></span>
			</div><!-- .entry-meta -->

			<div class="entry-summary">
				<div class="article-list-thumbnail">
					<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
						<?php the_post_thumbnail('article-tease'); ?>
					</a>
				</div>
				<div class="article-list-excerpt" style="vertical-align:middle">
					<?php the_excerpt(); ?>
				</div>
			</div>
			
			<div style="clear:both"></div>
			
			<!-- .entry-summary -->

		</div><!-- #post-## -->


<?php endwhile; // End the loop. Whew. ?>

<?php do_action( 'ode_pagination' ); ?>

<?php else: ?>
	
	<div class="message info"><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></div>
	
<?php endif; ?>