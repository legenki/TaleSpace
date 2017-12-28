<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */
get_header(); ?>
<div class="container error-page-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
				<h1><i>"</i><?php esc_html_e("404", 'javohome') ?></h1>
                <h2><?php esc_html_e("Ooops!", 'javohome') ?></h2>
                <h2><?php esc_html_e("Page  &nbsp;Not &nbsp;Found", 'javohome') ?></h2>
                <div class="error-details">
                    <p><?php esc_html_e("Sorry, the page you have requested has either been moved, or does not exist.", 'javohome') ?></p>
                </div>
                <div class="error-actions">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<span>
							<i class="fa fa-arrow-left"></i>
							<?php esc_html_e( "Go To Home", 'javohome' ); ?>
						</span>
					</a>
                </div>
            </div><!-- /.error-template -->
        </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
<?php get_footer(); ?>