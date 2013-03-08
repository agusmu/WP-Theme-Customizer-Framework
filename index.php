<?php get_header(); ?>

<section class="content">
<p> Im Just sample content</p>

<ul>
	
	<li><?php if(cw_get_option('cw_text')){ echo cw_get_option('cw_text'); } ?></li>

	<li><?php if(cw_get_option('cw_textarea')){ echo cw_get_option('cw_textarea'); } ?></li>

	<li><?php if(cw_get_option('cw_checkbox')){ echo cw_get_option('cw_checkbox'); } ?></li>
	
	<li><?php if(cw_get_option('cw_radio')){ echo cw_get_option('cw_radio'); } ?></li>
	
	<li><?php if(cw_get_option('cw_color')){ echo cw_get_option('cw_color'); } ?></li>
	
	<li><?php if(cw_get_option('cw_image')){ echo cw_get_option('cw_image'); } ?></li>
	
	<li><?php if(cw_get_option('cw_file')){ echo cw_get_option('cw_file'); } ?></li>

	<li><?php if(cw_get_option('cw_pages')){ echo cw_get_option('cw_pages'); } ?></li>

</ul>

</section>

<?php get_footer(); ?>