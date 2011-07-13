<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<div id="container">
	<div id="content" role="main">

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
		<div id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>
		
		<h1 class="entry-title"><?php the_title(); ?></h1>
							
		<?php if ( get_post_meta($post->ID, 'show_featured_image', true)  && 
				   get_post_meta($post->ID, 'show_featured_image', true ) == "false") {
						      // do nothing
					  } else {
					  	if (has_post_thumbnail()) { 
				?>
					<div class="entry-lead-image">
						<?php the_post_thumbnail(array(640,540)); ?>
					</div>
					<div class="entry-lead-image-caption">
						<?php the_post_thumbnail_caption(); ?>
					</div>
		<?php
				} // close the if that checked we actually have a post thumbnail before we write it out.
			} // close the if that checked if we were going to hide the image based on the custom filed "show_featured_image"
		?>
		
		<?php if (in_category('multimedia')) { ?>
		<div class="copyright-notice" style="margin-bottom:3px;">
			<span style="font-size: 12px;"><i>All photos and video are copyright Oregon Daily Emerald. All unauthorized use is strictly prohibited. Please contact <a href="mailto:publisher@dailyemerald.com">publisher@dailyemerald.com</a> for licensing.</i></span>
		</div>
		<?php } ?>
		
		<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
		<fb:like href="<?php the_permalink(); ?>" send="true" width="650" show_faces="false" action="recommend" font=""></fb:like>

		<div class="entry-meta">
			<?php iv_article_posted_on($post); ?>
		</div><!-- .entry-meta -->
		
		<?php if ( get_post_meta($post->ID, 'cp_author', true) ) : ?>
			<?php echo get_post_meta($post->ID, 'cp_author', true); // show cp_author, because this post is migrated from CP5 ?>
		<?php endif; // no cp_author, so this is a native post?>
		
		<?php if ( get_post_meta($post->ID, 'cp_image', true) ) : ?>
			<img src="
			<?php $images = explode("{}", get_post_meta($post->ID, 'cp_image', true)); // show cp_author, because this post is migrated from CP5 
				  echo $images[0];
			?>
			"></img>
		<?php endif; ?>
		
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		
		<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
			<div id="entry-author-info">
				<div id="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyten_author_bio_avatar_size', 60 ) ); ?>
				</div><!-- #author-avatar -->
				<div id="author-description">

					<h2><?php printf( esc_attr__( 'About %s', 'twentyten' ), get_the_author() ); ?></h2>
					<?php the_author_meta( 'description' ); ?>
					<div id="author-link">
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
							<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentyten' ), get_the_author() ); ?>
						</a>
					</div><!-- #author-link	-->
					
				</div><!-- #author-description -->
			</div><!-- #entry-author-info -->
		<?php endif; ?>
		
		<div class="entry-utility">
			<?php twentyten_posted_in(); ?>
			<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-utility -->
	</div><!-- #post-## -->
		
	<div id="nav-below" class="navigation">
		<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
		<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
	</div><!-- #nav-below -->

	<?php comments_template( '', true ); ?>
		
	<?php endwhile; // end of the loop. ?>

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


