<?php
/**
 * The search result template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */


$jvfrm_home_author	= new WP_User( get_the_author_meta( 'ID' ) ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="jv-single-post-header">

		<hgroup class="jv-single-post-title">
			<h3 class="page-header">
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( get_the_title() ); ?>">
					<?php the_title(); ?>
				</a>
			</h3>
		</hgroup>

		<section class="jv-single-post-meta">
			<ul class="list-inline">
				<li class="author-name"><?php esc_html( $jvfrm_home_author->display_name ); ?></li><li>/</li>
				<li class="date-posted">
					<a href="<?php the_permalink();?>">
						<i class="fa fa-calendar"></i> <?php echo get_the_date(); ?>
					</a>
				</li>
				<li>/</li>
				<li class="categories"><i class="fa fa-bookmark-o"></i> <?php the_category( ', ' ); ?></li>
				<?php if( comments_open() ) : ?>
				<li class="comments">/</li><li>
					<i class="fa fa-comments-o"></i>
					<?php
					comments_popup_link(
						esc_html__( '0 Comment', 'javohome' )
						, esc_html__( '1 Comment', 'javohome' )
						, esc_html__( '% Comments', 'javohome' )
					); ?>
				</li>
				<?php endif; ?>
			</ul>
		</section>
	</header><!-- /.jv-single-post-header -->

	<section class="jv-single-post-contents">
			<div class="entry-summary">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() );?>">
					<?php the_excerpt(); ?>
				</a>
			</div><!-- .entry-summary -->
	</section><!-- /. jv-single-post-contents -->
</article><!-- #post -->