<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
	</div><!-- #main -->

	<div class="bottom-google-ad" style="width: 481px; margin: auto auto 10px; height: 60px; overflow: hidden;">
		<script type="text/javascript"><!--
		google_ad_client = "pub-0391628171272725";
		/* 468x60, CP5 bottom banner */
		google_ad_slot = "2133692718";
		google_ad_width = 468;
		google_ad_height = 60;
		//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script><ins style="display:inline-table;border:none;height:60px;margin:0;padding:0;position:relative;visibility:visible;width:468px"><ins id="aswift_0_anchor" style="display:block;border:none;height:60px;margin:0;padding:0;position:relative;visibility:visible;width:468px"><iframe allowtransparency="true" frameborder="0" height="60" hspace="0" marginwidth="0" marginheight="0" onload="var i=this.id,s=window.google_iframe_oncopy,H=s&amp;&amp;s.handlers,h=H&amp;&amp;H[i],w=this.contentWindow,d;try{d=w.document}catch(e){}if(h&amp;&amp;d&amp;&amp;(!d.body||!d.body.firstChild)){if(h.call){i+='.call';setTimeout(h,0)}else if(h.match){i+='.nav';w.location.replace(h)}s.log&amp;&amp;s.log.push(i)}" scrolling="no" vspace="0" width="468" id="aswift_0" name="aswift_0" style="left:0;position:absolute;top:0;"></iframe></ins></ins>
	</div>

	<div id="footer" role="contentinfo">
		<div id="colophon">

<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	//get_sidebar( 'footer' );
?>

			<div id="site-info">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					&copy; <?php bloginfo( 'name' ); ?>
				</a>
			</div><!-- #site-info -->

			<div id="site-generator">
				<?php do_action( 'twentyten_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentyten' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentyten' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s.', 'twentyten' ), 'WordPress' ); ?></a>
			</div><!-- #site-generator -->

		</div><!-- #colophon -->
	</div><!-- #footer -->

</div><!-- #wrapper -->

<!-- ODE Google Analytics -->
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-22851831-1']);
    _gaq.push(['_trackPageview']);
    (function() {
   		var ga = document.createElement('script');     ga.type = 'text/javascript'; ga.async = true;
    	ga.src = ('https:'   == document.location.protocol ? 'https://ssl'   : 'http://www') + '.google-analytics.com/ga.js';
    	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
<!-- end ODE Google Analytics -->

<!-- START CMN Google tag-->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-18994242-2");
pageTracker._setCustomVar(1, "pu", anCPPaperUrl, 3);
pageTracker._setCustomVar(2, "pi", anCPPaperId, 3);
pageTracker._setCustomVar(3, "pn", anCPPaperName, 3);
pageTracker._setCustomVar(4, "ppp", anCPPipe, 3);
pageTracker._setCustomVar(5, "pcp", anCPCd, 3);
pageTracker._trackPageview();
} catch(err) {}
</script>
<!-- END CMN Google tag -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
<!--<?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds.-->
</body>
</html>
