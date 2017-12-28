<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

$jvfrm_home_author	= new WP_User( get_the_author_meta( 'ID' ) ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('jv-single-post-layout-1'); ?> >
	<header class="jv-single-post-header">
		<h3 class="hidden"><?php the_title();?></h3>
		<?php
		if( has_post_thumbnail() && !is_single() ) : ?>
			<div class="row">
				<div class="col-md-12">
					<section class="jv-single-post-thumbnail text-center">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full', Array( 'class' => 'img-responsive' ) ); ?>
						<div class="filter-overlay"></div>
						</a>
					</section><!-- .entry-header -->
				</div><!-- col-md-4 -->
			</div>
		<?php endif; ?>

		<?php if ( ! is_single() ) : ?>
			<hgroup class="jv-single-post-title">
				<h3 class="page-header">
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( get_the_title() ); ?>">
						<?php the_title(); ?>
					</a>
				</h3>
			</hgroup>
			<section class="jv-single-post-meta">
				<ul class="list-inline">
					<li class="author-name"><i class="glyphicon glyphicon-user"></i><?php echo esc_html( $jvfrm_home_author->display_name ); ?></li><li>/</li>
					<li class="date-posted"><a href="<?php the_permalink();?>"><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></a></li><li>/</li>
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
		<?php endif; ?>
	</header><!-- /.jv-single-post-header -->

	<section class="jv-single-post-contents">
		<?php do_action( 'jvfrm_home_post_content_inner_before' ); ?>
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content">				
				<?php if ( is_category() || is_archive() ) {
				    the_excerpt();
				} else {
					the_content( sprintf(
						wp_kses(__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'javohome' ), jvfrm_home_allow_tags() ),
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );

					wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'javohome' ), 'after' => '</div>' ) );
				} ?>
			</div><!-- .entry-content -->
		<?php endif; ?>
		<?php do_action( 'jvfrm_home_post_content_inner_after' ); ?>
	</section><!-- /. jv-single-post-contents -->

	<footer class="jv-single-post-footer">
		<div class="jv-single-post-tags text-left">
			<ul class="jv-single-post-tags-item-container list-inline no-margin">
				<?php
				the_tags( "<li><span class='jv-single-post-tag-icon glyphicon glyphicon-tags'></span></li><li><span class=\"jv-single-post-tags-item\">",
					'</span></li><li><span class="jv-single-post-tags-item">',
					'</span></li>'
				); ?>
			</ul><!-- /.jv-single-post-tags-item-container -->
		</div><!-- /.jv-single-post-tags -->
		<?php
		edit_post_link(
			sprintf( "<i class=\"fa fa-cog\"></i> %s", esc_html__( 'Edit', 'javohome' ) ),
				'<h5 class="edit-link">',
				'</h5>'
		); ?>
		<?php if( !is_single() && is_multi_author() && !( is_category() || is_archive() ) ) : ?>
			<div id="jv-single-post-author-info" class="media">
				<div class="media-body text-right">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<h4 class="media-heading"><?php printf( wp_kses(__( 'About <em>%s</em>', 'javohome'), jvfrm_home_allow_tags() ), get_the_author() ); ?></h4>
						<p><?php echo wp_kses( get_the_author_meta( 'description' ), jvfrm_home_allow_tags() ); ?></p>
					</a>
				</div><!-- /.media-body -->
				<div class="media-right">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php
						/** This filter is documented in author.php */
						$author_bio_avatar_size = apply_filters( 'jvfrm_home_drt_author_bio_avatar_size', 68 );
						echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size ); ?>
					</a>
				</div><!-- /.media-right -->
			</div><!--  /.media -->
		<?php endif; ?>
	</footer><!-- /. jv-single-post-footer -->
</article><!-- #post -->