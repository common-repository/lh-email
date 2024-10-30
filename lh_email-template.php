<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php echo $post->post_title; ?></title>

<style>
body {
background-image: url("images/slice.jpg");
margin: 0;
padding: 0;
font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
font-size: 87.5%; /* Resets 1em to 12px */
}


.html_link_spiel {
font-size: 0.8em;
}

img {
border: 0px; 
}


</style>


</head>
<body>


		
<div id="content">

<div><?php echo $message; ?></div>

			
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Single Bottombar')){ }  ?>

<p class="html_link_spiel">Having trouble viewing this email? <span class="html_link"><a href="<?php the_permalink($post->ID) ?>" >View it in your browser</a></span>.</p>

</div>
	

<ul id="bottom_adbar">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('LH Email Footer') ) : ?>
<?php endif; ?>
</ul>


</body>
</html>