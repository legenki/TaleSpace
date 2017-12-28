<?php
get_header();?>
<div class="container" id="javo-user-404-page-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="error-template">
				<h1><i>"</i><?php esc_html_e("Cannot &nbsp;find &nbsp;user", 'javohome') ?></h1>
				<div class="error-details">
					<p><?php esc_html_e("Sorry, no user exists with that username.", 'javohome') ?></p>
				</div>
				<div class="error-actions">
					<a href="javascript:history.back(-1);"><span><i class="fa fa-arrow-left"></i><?php esc_html_e('Go Back', 'javohome') ?></span></a>
				</div>
			</div><!--/.error-template-->
		</div><!-- /.col-md-12 -->
	</div><!--/.row -->
</div><!-- /#javo-user-404-page-wrap -->
<?php
get_footer();?>