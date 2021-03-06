<?php

register_sidebar(array(
  'name' => 'Banner',
  'description' => 'Banner',
  'before_title' => '',
  'after_title' => ''
));
register_sidebar(array(
  'name' => 'Center',
  'description' => 'Center',
  'before_title' => '',
  'after_title' => ''
));
register_sidebar(array(
  'name' => 'Lead',
  'description' => 'Lead',
  'before_title' => '',
  'after_title' => ''
));
register_sidebar(array(
  'name' => 'Bottom Left',
  'description' => 'Bottom Left',
  'before_title' => '',
  'after_title' => ''
));
register_sidebar(array(
  'name' => 'Bottom Right',
  'description' => 'Bottom Right',
  'before_title' => '',
  'after_title' => ''
));

add_theme_support('nav_menus');
register_nav_menu('header', 'Top header bar (for about, classified, etc)');

add_image_size('article-tease', 170, 120, false);

/* http://wordpress.org/support/topic/display-caption-with-the_post_thumbnail */
function the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
  }
}


/* from: http://stereointeractive.com/blog/2010/02/12/wordpress-get-post-images-and-the_post_thumbnail-caption/ */
function monahans_thumbnail_caption($html, $post_id, $post_thumbnail_id, $size, $attr)
{
  $attachment =& get_post($post_thumbnail_id);
 
  // post_title => image title
  // post_excerpt => image caption
  // post_content => image description
 
  if ($attachment->post_excerpt || $attachment->post_content) {
    $html .= '<p class="thumbcaption">';
    if ($attachment->post_excerpt) {
      $html .= '<span class="captitle">'.$attachment->post_excerpt.'</span> ';
    }
    $html .= $attachment->post_content.'</p>';
  }
 
	return $html;
}
//add_action('post_thumbnail_html', 'monahans_thumbnail_caption', null, 5);

/* remove Continue Reading link */
add_action( 'after_setup_theme', 'my_child_theme_setup' );
function my_child_theme_setup() {
	//remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );

	function ode_auto_excerpt_more( $more ) { return 'a-'.$output; }
	//add_filter( 'excerpt_more', 'ode_auto_excerpt_more', 5 );

	function ode_custom_excerpt_more( $output ) { return 'c-'.$output; }
	//add_filter( 'get_the_excerpt', 'ode_custom_excerpt_more', 5 );

	remove_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );
	remove_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );
}



/* from TwentyTen */
function iv_article_posted_on() {
	printf( __( '<span class="%1$s">Published</span> %2$s<br><h6 class="byline">By %3$s</h6>', 'twentyten' ),
	
		'meta-prep meta-prep-author',
	
		//sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a> at <span class="entry-time">%4$s</span>',
		sprintf( '<span class="entry-date">%3$s</span> at <span class="entry-time">%4$s</span>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date(),
			esc_attr( get_the_time() )
		),
		
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
		
	);
}
/*
<div class="entry-meta">
	<span class="meta-prep meta-prep-author">Published</span> 
	<a rel="bookmark" title="11:14 pm" href="http://cpemerald.sed2.info/2011/04/14/stamps-found-on-paper/">
		<span class="entry-date">April 14, 2011</span>
	</a> 
	<span class="meta-sep">by</span> 
	<span class="author vcard">
		<a title="View all posts by Ivar Vong" href="http://cpemerald.sed2.info/author/ivong/" class="url fn n">Ivar Vong</a>
	</span> 
	at 11:14 pm					
</div>
*/


/* remove non-news posts from the RSS feeds (job descriptions, layout categories, openings, advertising, about us, guides etc) */
function rss_feed_excluder($query) {
	if ($query->is_feed) {
		$query->set('cat','-63,-65,-4,-64,-125,-123,-6,-11,-84');
	}
	return $query;
}
add_filter('pre_get_posts','rss_feed_excluder');

// fix to make iframes work (http://blog.estherswhite.net/2009/11/customizing-tinymce/)
add_filter('tiny_mce_before_init', create_function( '$init_array',
     '$init_array["extended_valid_elements"] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
	  return $init_array;') 
);

/* Remove "extra" Twenty Ten Widget Areas *******************************************************/
function remove_widget_areas() {
	unregister_sidebar( 'secondary-widget-area' );
	unregister_sidebar( 'first-footer-widget-area' );
	unregister_sidebar( 'second-footer-widget-area' );
	unregister_sidebar( 'third-footer-widget-area' );
	unregister_sidebar( 'fourth-footer-widget-area' );
}
add_action( 'admin_init', 'remove_widget_areas');

/* disable auto p tagging because it's really annoying. */
//remove_filter( 'the_content', 'wpautop' );

