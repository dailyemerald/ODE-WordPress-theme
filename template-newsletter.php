<?php
/*
Template Name: Newsletter [stripped page] (Ivar)
*/
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<meta charset="UTF-8" />
<title>Oregon Daily Emerald | The independent student newsorg at the University of Oregon</title>
<link rel="stylesheet" type="text/css" media="all" href="/wp-content/themes/ode2/style.css" />
</head>

<body class="newsletter page">
	<div id="wrapper" class="hfeed">
		<div id="main">
	
			<div id="container">
				<div id="content" role="main">
	
				<?php if (have_posts()) : ?>
						   <?php while (have_posts()) : the_post(); ?>    
								<?php the_content(); ?>
						   <?php endwhile; ?>
				 <?php endif; ?>
	 
				</div><!-- #content -->
			</div><!-- #container -->
			
		</div><!-- #main -->
	</div><!-- #wrapper -->
</body>
</html>