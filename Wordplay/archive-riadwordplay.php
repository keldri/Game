<?php
/**
 * @package WordPress
 * @subpackage WPEX WordPress Framework
 * This file is used for your archive pages
 */

// Get template header
get_header();

// Sidebar Wrap?
if( of_get_option( 'sidebar_homepage_archive' ) == '1' ) echo '<div id="post" class="home-sidebar">';

// Start loop
if(have_posts()) : ?>
    <div id="archive-wrap" class="clearfix">
        <header id="page-heading">
            <?php $post = $posts[0]; ?>
            <?php if (is_category()) { ?>
            <h1><span><?php single_cat_title(); ?></span></h1>
            <?php } elseif (is_tax()) { ?>
            <h1><span><?php single_cat_title(); ?></span></h1>
            <?php } elseif( is_tag() ) { ?>
            <h1><span>&quot;<?php single_tag_title(); ?>&quot;</span></h1>
            <?php  } elseif (is_day()) { ?>
            <h1><span><?php _e('Archive for','wpex'); ?> <?php the_time('F jS, Y'); ?></span></h1>
            <?php  } elseif (is_month()) { ?>
            <h1><span><?php _e('Archive for','wpex'); ?> <?php the_time('F, Y'); ?></span></h1>
            <?php  } elseif (is_year()) { ?>
            <h1><span><?php _e('Archive for','wpex'); ?> <?php the_time('Y'); ?></span></h1>
            <?php  } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
            <h1><span><?php _e('Blog Archives','wpex'); ?></span></h1>
            <?php } ?>
        </header><!-- /page-heading -->
        
        <div id="archive-entries-wrap" class="clearfix">
    		<div class="grid-loader"><i class="icon-spinner icon-spin"></i></div>
            <div id="wpex-grid-wrap">
               <?php
                if (have_posts()) { 
                    while (have_posts()) {
                        the_post( );
                        $format = get_post_format();
                        if ( false === $format ) $format = 'standard';
                        get_template_part( '/formats/entry', $format );
                    }
                }
                ?>
            </div><!-- /wpex-grid-wrap --> 
            <?php if( of_get_option( 'pagination_style', 'infinite_scroll' ) == 'infinite_scroll' ) { ?>
                <?php wpex_infinite_scroll(); ?>
            <?php } elseif( of_get_option( 'pagination_style', 'infinite_scroll' ) == 'load_more' ) { ?>
                <?php echo aq_load_more(); ?>
            <?php } else { ?>
                <?php wpex_paginate_pages(); ?>
            <?php } ?>
		</div><!-- /archive-entries-wrap -->
            
    </div><!-- /archive-wrap -->
<?php
// End loop
endif;

// Get sidebar
if( of_get_option( 'sidebar_homepage_archive' ) == '1' ) {
	echo '</div>';
	get_sidebar();
}
// Get template footer
get_footer(); ?>