<?php
/*
Template Name: Slider demo (IV)
*/
get_header(); 
?>
<style text="text/css">
#featured{ 
	width:400px; 
	padding-right:250px; 
	position:relative; 
	border:5px solid #ccc; 
	height:250px; overflow:hidden;
	background:#fff;
}
#featured ul.ui-tabs-nav{ 
	position:absolute; 
	top:0; left:400px; 
	list-style:none; 
	padding:0; margin:0; 
	width:250px; height:250px;
	overflow:auto;
	overflow-x:hidden;
}
#featured ul.ui-tabs-nav li{ 
	padding:1px 0; padding-left:13px;  
	font-size:12px; 
	color:#666; 
}
#featured ul.ui-tabs-nav li img{ 
	float:left; margin:2px 5px; 
	background:#fff; 
	padding:2px; 
	border:1px solid #eee;
}
#featured ul.ui-tabs-nav li span{ 
	font-size:11px; font-family:Verdana; 
	line-height:18px; 
}
#featured li.ui-tabs-nav-item a{ 
	display:block; 
	height:60px; text-decoration:none;
	color:#333;  background:#fff; 
	line-height:20px; outline:none;
}
#featured li.ui-tabs-nav-item a:hover{ 
	background:#f2f2f2; 
}
#featured li.ui-tabs-selected{ 
	background:url('images/selected-item.gif') top left no-repeat;  
}
#featured ul.ui-tabs-nav li.ui-tabs-selected a{ 
	background:#ccc; 
}
#featured .ui-tabs-panel{ 
	width:400px; height:250px; 
	background:#999; position:relative;
}
#featured .ui-tabs-panel .info{ 
	position:absolute; 
	bottom:0; left:0; 
	height:70px; 
	background: url('images/transparent-bg.png'); 
}
#featured .ui-tabs-panel .info a.hideshow{
	position:absolute; font-size:11px; font-family:Verdana; color:#f0f0f0; right:10px; top:-20px; line-height:20px; margin:0; outline:none; background:#333;
}
#featured .info h2{ 
	font-size:1.2em; font-family:Georgia, serif; 
	color:#fff; padding:5px; margin:0; font-weight:normal;
	overflow:hidden; 
}
#featured .info p{ 
	margin:0 5px; 
	font-family:Verdana; font-size:11px; 
	line-height:15px; color:#f0f0f0;
}
#featured .info a{ 
	text-decoration:none; 
	color:#fff; 
}
#featured .info a:hover{ 
	text-decoration:underline; 
}
#featured .ui-tabs-hide{ 
	display:none; 
}
</style>

		<div id="container">
			<div id="content" role="main">

			
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" ></script>
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js" ></script>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#featured").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
					$("#featured").hover(
						function() {
							$("#featured").tabs("rotate",0,true);
						},
						function() {
							$("#featured").tabs("rotate",5000,true);
						}
					);
				});
			</script>
			<div id="featured" >
				
				<!-- First Content -->
				<div id="fragment-1" class="ui-tabs-panel" style="">
					<img src="images/image1.jpg" alt="" />
					 <div class="info" >
						<h2><a href="#" >15+ Excellent High Speed Photographs</a></h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla tincidunt condimentum lacus. Pellentesque ut diam....<a href="#" >read more</a></p>
					 </div>
				</div>
		
				<!-- Second Content -->
				<div id="fragment-2" class="ui-tabs-panel ui-tabs-hide" style="">
					<img src="images/image2.jpg" alt="" />
					 <div class="info" >
						<h2><a href="#" >20 Beautiful Long Exposure Photographs</a></h2>
						<p>Vestibulum leo quam, accumsan nec porttitor a, euismod ac tortor. Sed ipsum lorem, sagittis non egestas id, suscipit....<a href="#" >read more</a></p>
					 </div>
				</div>
		
				<!-- Third Content -->
				<div id="fragment-3" class="ui-tabs-panel ui-tabs-hide" style="">
					<img src="images/image3.jpg" alt="" />
					 <div class="info" >
						<h2><a href="#" >35 Amazing Logo Designs</a></h2>
						<p>liquam erat volutpat. Proin id volutpat nisi. Nulla facilisi. Curabitur facilisis sollicitudin ornare....<a href="#" >read more</a></p>
					 </div>
				</div>
		
				<!-- Fourth Content -->
				<div id="fragment-4" class="ui-tabs-panel ui-tabs-hide" style="">
					<img src="images/image4.jpg" alt="" />
					 <div class="info" >
						<h2><a href="#" >Create a Vintage Photograph in Photoshop</a></h2>
						<p>Quisque sed orci ut lacus viverra interdum ornare sed est. Donec porta, erat eu pretium luctus, leo augue sodales....<a href="#" >read more</a></p>
					 </div>
				</div>
				
				<ul class="ui-tabs-nav">
					<li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-1"><a href="#fragment-1"><img src="images/image1-small.jpg" alt="" /><span>15+ Excellent High Speed Photographs</span></a></li>
					<li class="ui-tabs-nav-item" id="nav-fragment-2"><a href="#fragment-2"><img src="images/image2-small.jpg" alt="" /><span>20 Beautiful Long Exposure Photographs</span></a></li>
					<li class="ui-tabs-nav-item" id="nav-fragment-3"><a href="#fragment-3"><img src="images/image3-small.jpg" alt="" /><span>35 Amazing Logo Designs</span></a></li>
					<li class="ui-tabs-nav-item" id="nav-fragment-4"><a href="#fragment-4"><img src="images/image4-small.jpg" alt="" /><span>Create a Vintage Photograph in Photoshop</span></a></li>
				</ul>
				
			</div>
			
				
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
