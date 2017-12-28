<!-- Modal -->
<div class="modal fade" id="register_panel" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="register_panelLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="register_panelLabel">
						<?php esc_html_e('Create Account', 'javohome');?>
					</h4>
				</div>
			<?php echo jvfrm_home_basic_scode()->createJoinForm( Array( 'close_button' => true ), null ); ?>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->