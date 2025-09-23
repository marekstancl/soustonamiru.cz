<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( $archive_readmore_text != '' ) :
		echo '<!-- Entry Button --><div class="entry-button wdt-core-button">';
			echo '<a href="'.get_permalink().'" title="'.the_title_attribute('echo=0').'" class="wdt-button">'.esc_html($archive_readmore_text).'<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 59" style="enable-background:new 0 0 100 59;" xml:space="preserve"><polygon points="59.9,6.1 79.4,25.7 6,25.7 6,33.3 79.4,33.3 59.9,52.9 65.3,58.2 94,29.5 65.3,0.8 "></polygon></svg></span></a>';
		echo '</div><!-- Entry Button -->';
	endif; ?>