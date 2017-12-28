<div class="jvfrm_home_somw_info panel {featured}">
	<div class="row jvfrm_home_somw_info_title">
		<div class="col-md-12 col-xs-12">
				<div class="row featured-show">
					<div class="content">
						<div class="ribbon"><?php esc_html_e( "Featured", 'javohome');?></div>
					</div><!-- /.content -->
				</div>
				<div class="">
					<div class="">
						<a href="{permalink}">
							{thumbnail}
						</a>
					</div><!--/.col-md-4 col-xs-4 -->
					<div class="col-md-12 col-xs-12">
						<div class="row">
							<div class="col-md-12 col-xs-12 text-left map-info-title">
								<h3><a href="{permalink}">{post_title}</a></h3>
							</div><!--/.col-md-12 col-xs-12 -->
							<div class="col-md-12 col-xs-12 text-left map-info-author">
								<span>{author_name}</span>
							</div><!--/.col-md-12 col-xs-12 -->
						</div><!--/.row-->
					</div><!--/.col-md-8 col-xs-8-->
				</div><!--/.row-->
		</div><!--/.col-md-12 col-xs-12-->
	</div><!--/.row-->
	<div class="jvfrm_home_somw_meta">
		{meta}
	</div> <!--// jvfrm_home_somw_meta -->
	{rating}
	<div class="jvfrm_home_somw_btns">
		<div class="row">
			<div class="col-md-6 jvfrm_home_social">
				<ul class="jvfrm_home_social_list">
					<li class="twitter">
						<a href="#" class="javo-share sns-twitter" data-title="{post_title}" data-url="{permalink}">
							<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x fa-inverse"></i></span>
						</a>
					</li>
					<li class="twitter">
						<a href="#" class="javo-share sns-facebook" data-title="{post_title}" data-url="{permalink}">
							<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x fa-inverse"></i></span>
						</a>
					</li>
					<li class="twitter">
						<a href="#" class="javo-share sns-google" data-title="{post_title}" data-url="{permalink}">
							<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-google-plus fa-stack-1x fa-inverse"></i></span>
						</a>
					</li>
				</ul>
			</div> <!-- //col-md-6 jvfrm_home_social -->
			<div class="col-md-6 jvfrm_home_btns_detail text-right">
				<button type="button" class="btn btn-primary btn-sm javo-infow-brief admin-color-setting" data-id="{post_id}">
					<i class="fa fa-user"></i> <span><?php _e("Brief", "javohome"); ?></span>
				</button>
				<button type="button" class="btn btn-primary btn-sm javo-infow-contact admin-color-setting" data-to="{email}" data-username="{author_name}" data-itemname="{post_title}">
					<i class="fa fa-envelope"></i> <span><?php _e("Contact", "javohome"); ?></span>
				</button>
				<button type="button" class="btn admin-color-setting" onclick="location.href='{permalink}';">
					<i class="fa fa-link"></i> <span><?php esc_html_e('Detail', 'javohome'); ?></span>
				</button>
			</div>
		</div>
	</div> <!--// jvfrm_home_somw_btns -->

</div> <!-- jvfrm_home_somw_info -->