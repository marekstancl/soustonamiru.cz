<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$img_size = array(
		'one-column' => 'full',
		'one-half-column' => 'wdt-blog-ii-column',
		'one-third-column' => 'wdt-blog-iii-column',
		'one-fourth-column' => 'wdt-blog-iv-column'
	);

	$post_column = vaathi_get_archive_post_column();

	if( has_post_thumbnail( $post_ID ) ) : ?>
		<a href="<?php echo get_permalink($post_ID);?>" title="<?php printf(esc_attr__('Permalink to %s','vaathi'), the_title_attribute('echo=0'));?>">
			<?php echo get_the_post_thumbnail( $post_ID, $img_size[$post_column] );?>
		</a><?php
	endif;
?>