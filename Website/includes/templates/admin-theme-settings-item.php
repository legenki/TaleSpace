<div class="jvfrm_home_ts_tab javo-opts-group-tab hidden" tar="property">
	<h2> <?php esc_html_e( "Property Settings", 'javohome'); ?> </h2>

	<table class="form-table">
	<tr><th>
		<?php esc_html_e( "Single Property", 'javohome');?>
		<span class="description">	</span>
	</th><td>

		<h4><?php esc_html_e( "Header Cover Style", 'javohome' ); ?></h4>
		<fieldset class="inner">
			<select name="jvfrm_home_ts[property_single_header_cover]">
				<?php
				$arrSingleItemHeaderCover	= apply_filters(
					'jvfrm_home_property_header',
					Array(
						''				=> esc_html__( "None", 'javohome' ),
						'shadow'	=> esc_html__( "Top & Bottom Shadow", 'javohome' ),
						'overlay'	=> esc_html__( "Full Cover Overlay", 'javohome' ),
					)
				);
				if( !empty( $arrSingleItemHeaderCover ) )
					foreach( $arrSingleItemHeaderCover as $classes => $label ) {
						printf(
							"<option value=\"{$classes}\" %s>{$label}</option>",
							selected( $jvfrm_home_tso->get( 'property_single_header_cover', 'overlay' ) == $classes, true, false )
						);
					}
				?>
			</select>
		</fieldset>

		<h4><?php esc_html_e( "Widget Sticky", 'javohome' ); ?></h4>
		<fieldset class="inner">
			<select name="jvfrm_home_ts[<?php echo jvfrm_home_core()->slug;?>_single_sticky_widget]">
			<?php
			foreach(
				Array(
					''			=> esc_html__( "Enable", 'javohome' ),
					'disable'	=> esc_html__( "Disable", 'javohome' ),
				)
			as $strOption => $strLabel )
				printf(
					"<option value=\"{$strOption}\" %s>{$strLabel}</option>",
					selected( $jvfrm_home_tso->get( jvfrm_home_core()->slug . '_single_sticky_widget', '' ) == $strOption, true, false )
				);
			?>
			</select>
		</fieldset>

		<h4><?php esc_html_e( "Map max width", 'javohome' ); ?></h4>
		<fieldset class="inner">
			<select name="jvfrm_home_ts[<?php echo jvfrm_home_core()->slug;?>_map_width_type]">
			<?php
			foreach(
				Array(
					''			=> esc_html__( "Full width", 'javohome' ),
					'boxed'	=> esc_html__( "Inner width", 'javohome' ),
				)
			as $strOption => $strLabel )
				printf(
					"<option value=\"{$strOption}\" %s>{$strLabel}</option>",
					selected( $jvfrm_home_tso->get( jvfrm_home_core()->slug . '_map_width_type', '' ) == $strOption, true, false )
				);
			?>
			</select>
		</fieldset>

		<?php if( function_exists( 'javo_home_single' ) ) : ?>
			<h4><?php printf( esc_html__( "Single Property - Layout Style", 'javohome' ), jvfrm_home_core()->getSlug() ); ?></h4>
			<fieldset class="inner">
				<select name="jvfrm_home_ts[property_single_type]">
					<?php
					$arrSingleCoreType = apply_filters(
						'jvfrm_home_property_header',
						Array(
							'' => esc_html__( "Default Type", 'javohome' ),
							'type-a' => esc_html__( "Dynamic A", 'javohome' ),
							'type-b' => esc_html__( "Dynamic B", 'javohome' ),
							'type-grid' => esc_html__( "Grid Layout", 'javohome' ),
							'type-half' => esc_html__( "Half Layout", 'javohome' ),
							'type-left-tab' => esc_html__( "Left Tab Layout", 'javohome' ),
							'type-top-tab' => esc_html__( "Top Tab Layout", 'javohome' ),
						)
					);
					if( !empty( $arrSingleCoreType ) ) : foreach( $arrSingleCoreType as $strValue => $strLabel ) {
						printf(
							"<option value=\"{$strValue}\" %s>{$strLabel}</option>",
							selected( jvfrm_home_tso()->get( 'property_single_type', 'type-grid' ) == $strValue, true, false )
						);
					} endif;
					?>
				</select>
			</fieldset>
		<?php endif; ?>

		<h4><?php esc_html_e( "Contact Form Settings", 'javohome' ); ?></h4>
		<fieldset class="inner">
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[single_listing_contact_type]" value='' <?php checked( '' == $jvfrm_home_tso->get('single_listing_contact_type') );?>>
				<?php esc_html_e( "None", 'javohome');?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[single_listing_contact_type]" value='contactform' <?php checked( 'contactform' == $jvfrm_home_tso->get('single_listing_contact_type') );?>>
				<?php esc_html_e( "Contact Form", 'javohome');?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[single_listing_contact_type]" value='ninjaform' <?php checked( 'ninjaform' == $jvfrm_home_tso->get('single_listing_contact_type') );?>>
				<?php esc_html_e( "Ninja Form", 'javohome');?>
			</label>

		</fieldset>
		<fieldset class="inner">
			<label>
				<?php esc_html_e('Contact Form ID', 'javohome');?><br>
				<input type="text" name="jvfrm_home_ts[single_listing_contact_form_id]" value="<?php echo esc_attr( $jvfrm_home_tso->get('single_listing_contact_form_id' ) );?>">
			</label>
			<p><?php esc_html_e('To create a Contact Form ID, please go to the Contact Form Menu.', 'javohome');?></p>
		</fieldset>

	</td></tr><tr><th>
		<?php esc_html_e( "Mobile Search", 'javohome');?>
		<span class="description">	</span>
	</th><td>
		<h4><?php esc_html_e( "Search Result Map Page", 'javohome' ); ?></h4>
		<fieldset class="inner">
			<select name="jvfrm_home_ts[property_mobile_search_requester]">
				<?php
				$arrTemplates	= apply_filters( 'jvfrm_home_get_map_templates',
					Array( esc_html__( "Not Set", 'javohome' ) => '' )
				);
				foreach( $arrTemplates as $label => $value )
					printf( "<option value=\"{$value}\" %s>{$label}</option>",
						selected( $jvfrm_home_tso->get( 'property_mobile_search_requester' ) == $value, true, false )
					);
				?>
			</select>
		</fieldset>

		<h4><?php esc_html_e( "Columns", 'javohome' ); ?></h4>
		<fieldset class="inner">
			<?php
			$arrColumns		= Array();
			for( $intCount=1; $intCount <= 3; $intCount++ )
				$arrColumns[]	= sprintf(
					"<option value=\"{$intCount}\" %s>{$intCount} %s</option>",
					selected( $jvfrm_home_tso->get( 'property_mobile_search_columns' , 1) == $intCount, true, false ) ,
					_n( 'Column', 'Columns', $intCount, 'javohome' )
				);


			// Columns
			echo join( '\n',
				Array(
					'<select name="jvfrm_home_ts[property_mobile_search_columns]">',
					join( '\n', $arrColumns ),
					'</select>',
				)
			);

			// Linked
			if( method_exists( 'jvfrm_home_search1', 'fieldParameter' ) ) {
				$arrParamsArgs		= jvfrm_home_search1::fieldParameter( null );
				$arrColumnFields		= isset( $arrParamsArgs[ 'value' ] ) ? $arrParamsArgs[ 'value' ] :Array();
				if( !empty( $arrColumnFields ) ) {
					for( $intCount=1; $intCount <= 3; $intCount++ ) {
						$strThisValue	= $jvfrm_home_tso->get( 'property_mobile_search_column' . $intCount );
						printf( "
							<p>
								<label>%s {$intCount}</label>
								<select name=\"jvfrm_home_ts[property_mobile_search_column{$intCount}]\">"
							, esc_html__( "Column", 'javohome' )
						);
							foreach( $arrColumnFields as $label => $key )
								printf( "<option value=\"{$key}\" %s>{$label}</option>",
									selected( $strThisValue == $key, true, false )
								);
							echo "</select>";
						echo "</p>";
					}
				}
			} ?>
		</fieldset>
	</td></tr>
	<?php if( function_exists( 'javo_home_single' ) ) : ?>
		<tr><th>
			<label><?php _e( "Google Map Styles On Single Property Pages", 'javohome' );?></label>
		</th>
		<td>
			<textarea name="jvfrm_home_ts[map_style_json]" rows="5" style="width:100%;"><?php echo stripslashes( jvfrm_home_tso()->get( 'map_style_json', null ) );?></textarea>
			<div>
				<?php
				printf(
					__( 'Please <a href="%1$s" target="_blank">click here</a> to create your own stlye and paste json code here.', 'javohome' ),
					esc_url( 'mapstyle.withgoogle.com' )
				); ?>
			</div>
			<div>
				<small>( <?php esc_html_e( "This code will overwritten map color setting", 'javohome' ); ?> )</small>
			</div>
		</td></tr>
	<?php endif; ?>
		<tr><th>
			<?php esc_html_e("Single Property Color Settings", 'javohome');?>
			<span class="description">
				<?php esc_html_e("The color set up here will have the first priority to be applied.", 'javohome');?>
			</span>
		</th><td>
			<h4><?php esc_html_e("Backgound Color",'javohome'); ?></h4>
			<fieldset class="inner">
				<input name="jvfrm_home_ts[single_page_background_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get('single_page_background_color','#f4f4f4') );?>" class="wp_color_picker" data-default-color="#f4f4f4">
			</fieldset>

			<h4><?php esc_html_e("Background Color (Box layout)",'javohome'); ?></h4>
			<fieldset class="inner">
				<input name="jvfrm_home_ts[single_page_box_background_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get('single_page_box_background_color','#ffffff') );?>" class="wp_color_picker" data-default-color="#ffffff">
			</fieldset>

			<h4><?php esc_html_e("Title Color",'javohome'); ?></h4>
			<fieldset class="inner">
				<input name="jvfrm_home_ts[single_page_title_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get('single_page_title_color','#666') );?>" class="wp_color_picker" data-default-color="">
			</fieldset>

			<h4><?php esc_html_e("Location Title Color",'javohome'); ?></h4>
			<fieldset class="inner">
				<input name="jvfrm_home_ts[single_page_location_title_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get('single_page_location_title_color','#ffffff') );?>" class="wp_color_picker" data-default-color="">
			</fieldset>

			<h4><?php esc_html_e("Description Text Color",'javohome'); ?></h4>
			<fieldset class="inner">
				<input name="jvfrm_home_ts[single_page_description_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get('single_page_description_color','#888888') );?>" class="wp_color_picker" data-default-color="#888888">
			</fieldset>
		</td>
		</tr>
	</table>
</div>