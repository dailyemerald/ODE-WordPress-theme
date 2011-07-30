<?php


/**
 * From: http://wordpress.org/support/topic/display-caption-with-the_post_thumbnail
 */
function the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ( $thumbnail_image && isset( $thumbnail_image[0] ) ) {
 		echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
  }
}

function ode_author_posts_link() {
	global $post;
	
	if ( $cp_byline = get_post_meta( $post->ID, '_cp_byline', true ) )
		echo 'By ' . esc_html( $cp_byline );
	else if ( function_exists( 'coauthors_posts_link' ) )
		coauthors_posts_link();
	else
		the_author_posts_link();
}

function ode_timestamp() {
	echo sprintf( '<span class="entry-date">%3$s</span> at <span class="entry-time">%4$s</span>',
		get_permalink(),
		esc_attr( get_the_time() ),
		get_the_date(),
		esc_attr( get_the_time() )
	);
}