<?php
/**
 * @package WordPress
 * @subpackage WPEX WordPress Framework
 */

//get template header
get_header();

//start post loop
while (have_posts()) : the_post(); ?>

<div id="post" class="clearfix">
	<div class="container clearfix">
		<?php
		$format = get_post_format();
		if ( false === $format ) $format = 'standard';
		
		if($format == 'quote') { ?>
			<div id="single-quote"><?php the_title(); ?>...
<?php the_content(); ?><div class="entry-quote-author"></div></div>
		<?php } elseif($format == 'link'){
			$post_url = get_post_meta(get_the_ID(), 'wpex_post_url', true); ?>
			<div id="single-media-wrap">
				<?php get_template_part( '/formats/single', $format ); ?>
        	</div><!-- /single-media-wrap -->
			<div id="single-link">
                <header id="single-heading">
                <h1><a href="<?php echo $post_url; ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></h1>
            </header><!-- /single-meta -->
            <article class="entry clearfix">
                <?php the_content(); ?>
                <a href="<?php echo $post_url; ?>" title="<?php the_title(); ?>" target="_blank"><span class="icon-link"></span><?php echo $post_url; ?></a>
        	</article><!-- /entry -->
           </div><!-- /single-link -->
		<?php } else { ?>
        <div id="single-media-wrap">
			<?php get_template_part( '/formats/single', $format ); ?>
        </div><!-- /single-media-wrap -->
        
		<header id="single-heading">
			<h1><?php the_title(); ?></h1>
			<section class="meta clearfix" id="single-meta">
				<ul>
					<li class="meta-single-date"><span class="icon-calendar"></span><?php the_date(); ?></li>    
					<li class="meta-single-cat"><span class="icon-folder-open"></span><?php the_category(' / '); ?></li>
					<li class="meta-single-user"><span class="icon-user"></span><?php the_author_posts_link(); ?></li>
					<?php if( comments_open() ) { ?>
						<li class="comment-scroll meta-single-comments"><span class="icon-comment"></span> <?php comments_popup_link(__('Leave a comment', 'wpex'), __('1 Comment', 'wpex'), __('% Comments', 'wpex'), 'comments-link', __('Comments closed', 'wpex')); ?></li>
						<?php } ?>
					<?php if( !function_exists('zilla_likes') ) { ?><li class="meta-single-zilla-likes"><?php zilla_likes(); ?></li><?php } ?>
				</ul>
			</section><!--/meta -->
		</header><!-- /single-meta -->
        
        <article class="entry clearfix" id="puzzle">
            <?php the_content(); ?>
        </article><!-- /entry -->
        
        <?php wp_link_pages(' '); ?>
        
        <?php
        //post tags
        //if(of_get_option('blog_tags') =='1') {
            //the_tags('<div class="post-tags clearfix">','','</div>');
        //}
        ?>
        
        <?php
        //author bio
       /* if(of_get_option('blog_bio') == '1') { ?>
        <div id="single-author" class="clearfix">
            <div id="author-image">
               <?php echo get_avatar( get_the_author_meta('user_email'), '60', '' ); ?>
            </div><!-- author-image --> 
            <div id="author-bio">
                <h4><?php the_author_posts_link(); ?></h4>
                <p><?php the_author_meta('description'); ?></p>
            </div><!-- author-bio -->
        </div><!-- /single-author -->
        <?php } */ ?>
        
		<?php
        //share post
        /*if(of_get_option('blog_social') == '1') { ?>
        <div id="single-share" class="clearfix">
        	<h4><span class="icon-plus"></span><?php _e('Share This Post','wpex') ?></h4>
            <div class="share-btns">
                <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
                <div class="fb-like" data-send="false" data-show-faces="false" data-layout="button_count"></div>
                <div class="g-plusone" data-size="medium"></div>
                <a data-pin-config="above" href="//pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
            </div><!-- /share-btns -->
        </div><!-- /single-share -->
        <?php }*/ ?>
        
	<?php } ?>
        
	</div><!-- /container -->
        
        <nav id="single-nav" class="clearfix"> 
            <?php next_post_link('<div id="single-nav-left">%link</div>', '<span class="icon-chevron-left"></span>'.__('Previous Post','wpex').'', false); ?>
            <?php previous_post_link('<div id="single-nav-right">%link</div>', ''.__('Next Post','wpex').'<span class="icon-chevron-right"></span>', false); ?>
        </nav><!-- /single-nav -->
        
        <?php
        //show comments if not disabled
        //if(of_get_option('blog_comments','1')) {
			//comments_template(); } ?>
        
</div><!-- /post -->

<?php
//end post loop
endwhile;

//get template sidebar
get_sidebar(); ?>

	<?php /*if(of_get_option('related_random_show') =='1') {*/ ?>
		<?php /*get_template_part( 'content', 'related' );*/ ?>
	<?php /*}*/ ?>

<?php
//get template footer
get_footer(); ?>