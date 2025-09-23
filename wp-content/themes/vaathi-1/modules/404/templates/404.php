<?php
    if( isset( $enable_404message ) && ( $enable_404message == 1 || $enable_404message == true )  ) {
        $class = $notfound_style;
        $class .= ( isset( $notfound_darkbg ) && ( $notfound_darkbg == 1 ) ) ? " wdt-dark-bg" :"";
    ?>
    <div class="wrapper <?php echo esc_attr( $class );?>">
        <div class="container">
            <div class="center-content-wrapper">
                <div class="center-content">
                    <div class="error-box square">
                        <div class="error-box-inner">
                            <h3><?php esc_html_e("404 - Error", 'vaathi'); ?></h3>
                            <h4><?php esc_html_e("This Page Needs an Life lesson", 'vaathi'); ?></h4>
                        </div>
                    </div>
                    <div class="wdt-hr-invisible-xsmall"></div>
                    <p><?php esc_html_e("Mauris porttitor vitae metus vel dignissim. Nam elementum nisl nec ligula bibendum, id sagittis ante venenatis. Suspendisse est elit, tempus quis gravida non, tincidunt vitae magna.", 'vaathi'); ?></p>
                    <div class="wdt-hr-invisible-xsmall"></div>
                    <a class="wdt-button filled small" target="_self" href="<?php echo esc_url(home_url('/'));?>"><?php esc_html_e("Back To Home",'vaathi');?></a>
                </div>
            </div>
        </div>
    </div><?php
}?>