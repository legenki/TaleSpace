<div class="row half-wrap">
		<div class="col-md-5 half-left-wrap">
			<?php
			//dynamic style body
			include "addon-header-dynamic.php";
			?>			
		</div> <!-- col-md-5 half-left-wrap -->
		<div class="col-md-7 half-right-wrap">
				<div class="single-item-tab property type-property half-right-inner javo-spyscroll">

				<?php
			//dynamic style body
			include "addon-header-spyscroll-nav.php";
			?>		
					<?php
					// Single page addon option
					if( class_exists( 'Javo_Home_Single_Addon' ) ){
						$single_addon_options = get_single_addon_options(get_the_ID());
					}
					?>
					<div class="half-right-content">
						<div class="container">
							<div class="row">
								<div id="javo-single-content" class="col-md-12 col-xs-12 property-single">
									<?php
										//dynamic style body
										include "addon-body-dynamic.php";
									?>
								</div> <!-- javo-single-content item-single -->
							</div> <!-- row -->
						</div> <!-- container -->
				</div> <!-- half-right-content -->
			</div> <!-- single-item-tab -->
		</div> <!-- col-md-7 half-right-wrap -->
	</div> <!-- row -->