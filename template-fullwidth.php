<?php
/*
Template Name: Full width page (for multimedia/photo/etc) (Ivar)
*/
get_header(); 
?>

		<div id="container full-width">
			<div id="content" role="main">

				<div id="banner-well">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Banner") ) : ?><?php endif; ?>
				</div> <!-- #banner-well -->
				
				<div style="clear:both"></div>
				
			<?php if ($lead_well_position == "left") { ?>
				<div id="lead-well">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Lead") ) : ?>No lead sidebar<?php endif; ?>
				</div><!-- #lead-well -->
			<?php } ?>
				
				<div id="center-well">
					
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Center") ) : ?>No center sidebar<?php endif; ?>
					
					<div id="bottom-left-well">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Bottom Left") ) : ?>No bottom left sidebar<?php endif; ?>
					</div><!-- #bottom-left-well -->
	
					<div id="bottom-right-well">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Bottom Right") ) : ?>No bottom right sidebar<?php endif; ?>
					</div> <!-- #bottom-right-well -->
					
				</div><!-- #center-well -->

			<?php if ($lead_well_position == "right") { ?>
				<div id="lead-well">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Lead") ) : ?>No lead sidebar<?php endif; ?>
				</div><!-- #lead-well -->
			<?php } ?>
				
				
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
