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

function ode_author() {
	echo ode_get_author();
}

function ode_get_author() {
	global $post;

	if ( $cp_byline = get_post_meta( $post->ID, '_cp_byline', true ) )
		$author = esc_html( $cp_byline );
	else
		$author = get_the_author();
		
	return $author;
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

/**
 * Standardized pagination we can use anywhere in the loop
 */
function ode_pagination() {
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

	$pagination = array(
		'base' => @add_query_arg('page','%#%'),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => $current,
		'type' => 'plain'
		);

	if( $wp_rewrite->using_permalinks() )
		$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

	if( !empty($wp_query->query_vars['s']) )
		$pagination['add_args'] = array( 's' => get_query_var( 's' ) );

	echo "<div class='pagination'><span class='float-right total-results'>Total results: " . $wp_query->found_posts . "</span>" . paginate_links( $pagination ) . '<span class="clear-both"></span></div>';
	
	echo "<div class='clear-both'></div>";
	
}