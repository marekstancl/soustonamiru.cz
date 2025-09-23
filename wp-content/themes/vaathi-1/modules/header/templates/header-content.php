<div class="container">
    <div class="wdt-no-header-builder-content wdt-no-header-vaathi">
        <div class="no-header">
            <div class="no-header-logo">
                <a href="<?php echo esc_url( home_url('/') );?>" title="<?php esc_attr(bloginfo('title')); ?>"><?php echo vaathi_get_header_logo();?></a>
            </div>
            <?php
                $menu = false;
                if( has_nav_menu('main-menu') ) { ?>
                    <div class="no-header-menu wdt-header-menu" data-menu="dummy-menu">
                        <?php

                            $menu = wp_nav_menu( apply_filters( 'vaathi_default_menu_args', array(
                                'theme_location'  => 'main-menu',
                                'container_class' => 'menu-container',
                                'items_wrap'      => '<ul id="%1$s" class="%2$s" data-menu="dummy-menu"> <li class="close-nav"><a href="javascript:void(0);"></a></li> %3$s </ul> <div class="sub-menu-overlay"></div>',
                                'menu_class'      => 'wdt-primary-nav',
                                'link_before'     => '<span>',
                                'link_after'      => '</span>',
                                'walker'          => new Vaathi_Default_Header_Walker_Nav_Menu,
                                'echo'            => false
                            ) ) );

                            echo apply_filters( 'vaathi_default_menu', $menu );

                            if( $menu ) { ?>
                                <div class="mobile-nav-container" data-menu="dummy-menu">
                                    <a href="javascript:void(0);" class="menu-trigger menu-trigger-icon" data-menu="dummy-menu">
                                        <i></i>
                                        <span><?php esc_html_e('Menu', 'vaathi'); ?></span>
                                    </a>
                                    <div class="mobile-menu mobile-nav-offcanvas-right" data-menu="dummy-menu"></div>
                                </div><?php
                            } ?>
                    </div><?php
                }?>
        </div>
    </div>
</div>