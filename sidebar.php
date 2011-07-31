<div id="primary" class="widget-area" role="complementary">
	<ul class="xoxo">

<?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>

		
<?php endif; // end primary widget area ?>

	<?php // GODUCKS VIDEO ADVERTISEMENT -- ONLY SHOW IF CATEGORY_NAME == SPORTS (ADDED BY IVAR, MAY 11, 2011)
		  if (is_category('sports') || in_category('sports')) { // 9 is the ID for the Sports category... i think.
	?>
		<li id="goducks-sports-ad" class="widget-container">
			<div style="width: 300px; height: 330px;">	
			<div style="text-align: center; font-size: 10px; background: none repeat scroll 0% 0% rgb(255, 255, 255); padding: 5px 1px 1px;">ADVERTISEMENT</div>
				<table width="300" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr><td>
				<object width="300" height="318" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="iptvsyndicated">
					<param value="http://www.goducks.com/mediaPortal/inline.swf" name="movie">
					<param value="playerId=20507&amp;server=http://www.goducks.com/XML/titanv3/&amp;pageurl=http://www.goducks.com/mediaPortal/&amp;sitename=aff.oregon.dailyemerald&amp;locimage=http://image.cdnl3.xosnetwork.com/mediaPortal/&amp;jtv=500&amp;skin=500&amp;gaa=UA-8512810-1&amp;companion=true&amp;htmlid=iptvsyndicated&amp;brandTextColor=0xCCCCCC&amp;brandTextSelectedColor=0xFFFFFF&amp;autostart=true&amp;mute=true" name="flashVars">
					<param value="high" name="quality">
					<param value="true" name="allowFullScreen">
					<param value="always" name="allowScriptAccess">
					<embed width="300" height="318" flashvars="playerId=20507&amp;server=http://www.goducks.com/XML/titanv3/&amp;pageurl=http://www.goducks.com/mediaPortal/&amp;sitename=aff.oregon.dailyemerald&amp;locimage=http://image.cdnl3.xosnetwork.com/mediaPortal/&amp;jtv=500&amp;skin=500&amp;gaa=UA-8512810-1&amp;companion=true&amp;htmlid=iptvsyndicated&amp;brandTextColor=0xCCCCCC&amp;brandTextSelectedColor=0xFFFFFF&amp;autostart=true&amp;mute=true" allowscriptaccess="always" allowfullscreen="true" quality="high" type="application/x-shockwave-flash" src="http://www.goducks.com/mediaPortal/inline.swf" pluginspage="http://www.adobe.com/go/getflashplayer" name="iptvsyndicated">
				</object>
				</td></tr>
				</tbody>
				</table>
			</div>
		</li>
	<?php } ?>
			
			</ul>
			
		</div><!-- #primary .widget-area -->

<?php if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>

	<div id="secondary" class="widget-area" role="complementary">
		<ul class="xoxo">
			<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
		</ul>
	</div><!-- #secondary .widget-area -->

<?php endif; ?>
