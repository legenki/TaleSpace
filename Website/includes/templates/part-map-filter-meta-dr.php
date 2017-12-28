<?php
$jvfrm_home_propertyMeta		= (Array) apply_filters( 'lava_' . self::SLUG . '_more_meta', Array() ) ;
$jvfrm_home_meta_filters			= Array_diff(
	Array_Keys( $jvfrm_home_propertyMeta )
	, Array( '_price_prefix', '_area_prefix', '_phone1', '_vendor', '_video_id', '_video_portal', '_3dViewer', '_booking','_facebook_link','_twitter_link','_instagram_link','_google_link' )
);
if( !empty( $jvfrm_home_meta_filters  ) ) :  foreach( $jvfrm_home_meta_filters as $key ) {
	?>
	<div class="row text-left">
		<div class="col-md-3 jv-advanced-titles">
			<?php echo esc_html( $jvfrm_home_propertyMeta[$key][ 'label' ] ); ?>
		</div><!-- /.col-md-3 -->
		<div class="col-md-9 jv-advanced-fields">
			<select data-metakey="<?php echo esc_attr( $key ); ?>" data-name="<?php echo esc_attr( $jvfrm_home_propertyMeta[$key][ 'label' ] ); ?>" class="form-control">
				<option value=''><?php esc_html_e( "All", 'javohome' ); ?></option>
				<?php
				$parsePost = get_object_vars( $post );
				for( $intCount=1; $intCount <= 10; $intCount++ )
					printf( "<option value=\"{$intCount}\"%s>{$intCount}</option>",
						selected( isset( $parsePost[ 'req' . $key ] ) && ($parsePost[ 'req' . $key ] == $intCount ), true, false )
					);
				?>
			</select>
		</div><!-- /.col-md-9 -->
	</div>
	<?php
} endif;