<div class="modal fade" id="author_contact" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php _e("Contact ", "javohome"); ?><span class="javo-contact-user-name"></span></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="contact_name" class="col-sm-2 control-label"><?php _e("Name", "javohome"); ?></label>
						<div class="col-sm-10">
							<input name="contact_name" id="contact_name" class="form-control" placeholder="<?php _e('Insert your name','javohome');?>" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="contact_email" class="col-sm-2 control-label"><?php _e("Email", "javohome"); ?></label>
						<div class="col-sm-10">
							<input name="contact_email" id="contact_email" class="form-control" placeholder="<?php _e('Insert your E-mail address.','javohome');?>" type="email">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<textarea name="contact_content" id="contact_content" class="form-control" rows="5"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<input id="contact_submit" class="btn btn-primary col-md-12" value="<?php _e("Send a message", "javohome");?>" type="button">
						</div>
					</div>
					<input type="hidden" name="contact_this_from">
					<input type="hidden" name="contact_item_name">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Close", "javohome"); ?></button>
			</div>
		</div>
	</div>
</div>