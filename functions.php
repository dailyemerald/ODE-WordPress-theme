<?php
define( 'ODE_VERSION', '0.0' );

if ( !class_exists( 'ode' ) ) {
	
class ode
{
	
	var $options_group = 'ode_';
	var $options_group_name = 'ode_options';
	var $settings_page = 'ode_settings';
	
	var $options_defaults = array(
		'sphinx_enabled' => 'off',
		'sphinx_index' => '',
	);
	
	function __construct() {
		
		$this->options = array_merge( $this->options_defaults, get_option( $this->options_group_name ) );
		
		if ( is_admin() ) {
			require_once( 'php/class.ode_post.php' );
			$this->post = new ode_post();
		} else {
			require_once( 'php/class.highlighter.php' );
			require_once( 'php/template-tags.php' );
			require_once( 'php/sphinxapi.php' );
			require_once( 'php/class.sphinxsearch.php' );
			$this->search = new sphinxsearch();
		}
		
		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'article-tease', 170, 120, false );
		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		
		add_theme_support( 'nav_menus' );
		
		add_action( 'init', array( &$this, 'action_init' ) );
		
		if ( !is_admin() && isset( $this->options['sphinx_enabled'] ) && $this->options['sphinx_enabled'] == 'on' ) {
			add_action( 'init', array( &$this->search, 'initialize' ) );
		}
		
		add_action( 'admin_init', array( &$this, 'action_admin_init' ) );
		add_action( 'admin_menu', array( &$this, 'action_admin_menu' ) );
		if ( is_admin_bar_showing() )
			add_action( 'admin_bar_menu', array( &$this, 'action_admin_bar_menu_150' ), 150 );
			
		//add_filter( 'manage_posts_columns', array( &$this, '_filter_manage_posts_authors_column' ) );			
		
	}
	
	function _filter_manage_posts_authors_column( $column_name ) {
		
		if ( $column_name == 'author' ) {
			global $post;
			if ( $cp_byline = get_post_meta( $post->ID, '_cp_byline', true ) )
				echo esc_html( $cp_byline );
		}

	}
	
	function action_init() {
		
		$sidebars = array(
			'Banner',
			'Center',
			'Lead',
			'Bottom Left',
			'Bottom Right',
		);
		foreach( $sidebars as $sidebar ) {
			$args = array(
				'name' => $sidebar,
				'description' => $sidebar,
				'before_title' => '',
				'after_title' => ''
			);
			register_sidebar( $args );
		}
		
		$this->enqueue_resources();
		
		register_nav_menu('header', 'Top header bar (for about, classified, etc)');
		
		// Template-specific methods
		add_action( 'wp_head', 'ode_head_title_description' );		
		add_action( 'wp_head', 'ode_head_fb_open_graph' );
		add_action( 'ode_author', 'ode_author' );
		add_action( 'ode_author_posts_link', 'ode_author_posts_link' );		
		add_action( 'ode_timestamp', 'ode_timestamp' );
		
	}
	
	function action_admin_init() {
		
		$this->register_settings();
		
	}
	
	function action_admin_menu() {

		add_submenu_page( 'themes.php', 'ODE Theme Options', 'Theme Options', 'manage_options', 'ode_options', array( &$this, 'options_page' ) );			

	}
	
	function action_admin_bar_menu_150() {
		global $wp_admin_bar;
	
		if ( current_user_can( 'manage_options' ) ) {
			$args = array(
				'title' => 'Theme Options',
				'href' => admin_url( 'themes.php?page=ode_options' ),
				'parent' => 'appearance',
			);
			$wp_admin_bar->add_menu( $args );
			$args = array(
				'title' => 'Edit CSS',
				'href' => admin_url( 'themes.php?page=editcss' ),
				'parent' => 'appearance',
			);
			$wp_admin_bar->add_menu( $args );
		}
	}
	
	/**
	 * enqueue_resources()
	 * Enqueue any resources we need
	 */
	function enqueue_resources() {

		if ( !is_admin() ) {
			wp_enqueue_style( 'twentyten_css', get_bloginfo('template_directory') . '/style.css', false, ODE_VERSION );			
			wp_enqueue_style( 'ode_primary_css', get_bloginfo('template_directory') . '/css/ode.css', array( 'twentyten_css' ), ODE_VERSION );
		}

	} // END enqueue_resources()	
	
	function register_settings() {

		register_setting( $this->options_group, $this->options_group_name, array( &$this, 'settings_validate' ) );
		
		// Sphinx options
		add_settings_section( 'ode_sphinx', 'Sphinx Search', array( &$this, 'settings_sphinx_section' ), $this->settings_page );
		add_settings_field( 'sphinx_enabled', 'Sphinx is: ', array( &$this, 'settings_sphinx_enabled_option' ), $this->settings_page, 'ode_sphinx' );	
		add_settings_field( 'sphinx_index', 'Index to use', array( &$this, 'settings_sphinx_index_option' ), $this->settings_page, 'ode_sphinx' );			

	}
	
	function settings_sphinx_section() {
		echo '<p>These settings are configured once for using Sphinx as your search indexer. Sphinx means more relevant search results.</p>';
	}
	
	/**
	 * Whether or not Sphinx is used as the search engine
	 */
	function settings_sphinx_enabled_option() {

		$options = $this->options;
		echo '<select id="sphinx_enabled" name="' . $this->options_group_name . '[sphinx_enabled]">';
		echo '<option value="off"';
		if ( isset( $options['sphinx_enabled'] ) && $options['sphinx_enabled'] == 'off' ) {
			echo ' selected="selected"';
		}		
		echo '>Disabled</option>';
		echo '<option value="on"';
		if ( isset( $options['sphinx_enabled'] ) && $options['sphinx_enabled'] == 'on' ) {
			echo ' selected="selected"';
		}		
		echo '>Enabled</option>';
		echo '</select>';

	}
	
	/**
	 * Sphinx index to use
	 */
	function settings_sphinx_index_option() {
		$options = $this->options;
		echo '<input id="sphinx_index" name="' . $this->options_group_name . '[sphinx_index]"';
		if ( isset( $options['sphinx_index'] ) ) {
			echo ' value="' . $options['sphinx_index'] . '"';
		}		
		echo ' size="80" />';
		echo '<p class="description">(optional) Defaults to "*"</p>';	
	}
	
	/**
	 * Validation and sanitization on the settings field
	 */
	function settings_validate( $input ) {
		
		if ( $input['sphinx_enabled'] != 'on' ) {
			$input['sphinx_enabled'] = 'off';
		}		
		$input['sphinx_index'] = wp_kses_post( $input['sphinx_index'] );
		return $input;

	}
	
	/**
	 * Options page for the theme
	 */
	function options_page() {
		?>                                   
		<div class="wrap">
			<div class="icon32" id="icon-options-general"><br/></div>

			<h2><?php _e('Daily Emerald Options', 'ode-theme') ?></h2>

			<form action="options.php" method="post">

				<?php settings_fields( $this->options_group ); ?>
				<?php do_settings_sections( $this->settings_page ); ?>

				<p class="submit"><input name="submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" /></p>

			</form>
		</div>
		<?php
	}
	
	
}	
	
}

global $ode;
$ode = new ode();

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

/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );

	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	if ( ! defined( 'NO_HEADER_TEXT' ) )
		define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See twentyten_admin_header_style(), below.
	add_custom_image_header( '', 'twentyten_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Berries', 'twentyten' )
		),
		'cherryblossom' => array(
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cherry Blossoms', 'twentyten' )
		),
		'concave' => array(
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Concave', 'twentyten' )
		),
		'fern' => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Fern', 'twentyten' )
		),
		'forestfloor' => array(
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Forest Floor', 'twentyten' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'twentyten' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'twentyten' )
		),
		'sunset' => array(
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sunset', 'twentyten' )
		)
	) );
}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'twentyten' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'twentyten' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'twentyten' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'twentyten' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'twentyten' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'twentyten' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Twenty Ten 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;


