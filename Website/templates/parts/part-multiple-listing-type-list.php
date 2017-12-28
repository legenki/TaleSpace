<?php
$arrListingFilters	= apply_filters( 'jvfrm_home_' . $post->lava_type . '_map_list_filters', Array() );
$strListOutputClass = sprintf(
	'class="%s"', join(
		' ',
		apply_filters(
			'jvfrm_home_map_list_output_class',
			Array( 'javo-shortcode' )
		)
	)
); ?>
<div id="map-list-style-wrap" <?php jvfrm_home_map_class( 'container' ); ?>>
	<?php do_action( 'jvfrm_home_' . $post->lava_type . '_map_list_wrap_before', $post ); ?>
	<div class="row">
		<div class="col-md-3 col-sm-3 hidden-xs jvfrm_home_map_list_sidebar_wrap">
			<?php
			$arrJavoOutput								= Array();
			if( !empty( $arrListingFilters ) ) : foreach( $arrListingFilters as $partFilter ) {
				foreach( $partFilter as $wrap => $wrap_meta ) {
					$arrJavoOutput[]							= "<div id=\"{$wrap}\" class=\"panel panel-default panel-accordion panel-checkbox panel-more\">";
						$arrJavoOutput[]						= sprintf( "
							<div class=\"panel-heading\"  data-toggle=\"collapse\" data-target=\"#{$wrap}-collapse\">
								<h3 class=\"panel-title\">%s</h3><span class=\"toggle chevron\"></span>
							</div>"
							, $wrap_meta[ 'label' ]
						);
						$arrJavoOutput[]						= "<div class=\"panel-collapse collapse in\" id=\"{$wrap}-collapse\">";
							$arrJavoOutput[]					= "<div class=\"panel-body\">";

							if( !empty( $wrap_meta[ 'inner' ] ) ) : foreach( $wrap_meta[ 'inner' ] as $element ) {
								$arrJavoOutput[]			= "<div class=\"form-group\">";

									switch( $element[ 'type' ] ){
										case 'separator' :
											$arrJavoOutput[]	= '<hr>';
											break;

										case 'division' :
											$arrJavoOutput[]	= "<div class=\"{$element[ 'class' ]}\"></div>";
											break;

										case 'select':

											if( isset( $element[ 'taxonomy' ] ) && taxonomy_exists( $element[ 'taxonomy' ] ) ) {
												$arrJavoOutput[]	= "
													<select
														name=\"list_filter[{$element[ 'taxonomy' ]}]\"
														data-tax=\"{$element[ 'taxonomy' ]}\"
														class=\"{$element[ 'class' ]}\">";
													$arrJavoOutput[]	= "<option value=''>{$element[ 'placeholder' ]}</option>";
													$arrJavoOutput[]	= apply_filters(
														'jvfrm_home_get_selbox_child_term_lists'
														, $element['taxonomy']
														, null
														, 'select'
														, $element[ 'value' ]
														, 0
														, 0
														, '-'
													);
												$arrJavoOutput[]	= "</select>";
											}else if( isset( $element[ 'meta' ] ) ) {
												$intLoopMIN			= !empty( $element[ 'range' ][0] ) ? intVal( $element[ 'range' ][0] ) : 0;
												$intLoopMAX		= !empty( $element[ 'range' ][1] ) ? intVal( $element[ 'range' ][1] ) : 10;
												$arrJavoOutput[]	= "
													<select
														name=\"list_filter[{$element[ 'meta' ]}]\"
														data-metakey=\"{$element[ 'meta' ]}\"
														class=\"{$element[ 'class' ]}\">";
													$arrJavoOutput[]	= "<option value=''>{$element[ 'placeholder' ]}</option>";
													for( $intLoopCUR=$intLoopMIN; $intLoopCUR <= $intLoopMAX; $intLoopCUR++ )
														$arrJavoOutput[]	= sprintf( "<option value=\"{$intLoopCUR}\" %s>{$intLoopCUR}</option>",
															selected( $intLoopCUR == $element[ 'value' ], true, false )
														);
												$arrJavoOutput[]	= "</select>";
											}
											break;
										case 'checkbox' :
											if(
												taxonomy_exists( $element[ 'taxonomy' ] ) &&
												$terms = get_terms( $element['taxonomy'], Array( 'hide_empty' => 0 ) )
											) foreach( $terms as $term ) {
												$arrJavoOutput[]			= "<div class=\"checkbox\">";
													$arrJavoOutput[]		= "<label>";
														$arrJavoOutput[]	= "<span class=\"check\"></span>";
														$arrJavoOutput[]	= "<input type=\"checkbox\" name=\"jvfrm_home_list_multiple_filter\" value=\"{$term->term_id}\"" . ' ';
														$arrJavoOutput[]	= "class=\"tclick\" data-tax=\"{$term->taxonomy}\"";
														$arrJavoOutput[]	= checked( in_Array( $term->term_id, $element[ 'value' ] ) , true, false );
														$arrJavoOutput[]	= ">";

														$arrJavoOutput[]	= $term->name;
													$arrJavoOutput[]		= "</label>";
												$arrJavoOutput[]			= "</div>";
											}
											break;
										case 'location' :
											$arrJavoOutput[]				= "<div class=\"input-group\">";

												$arrJavoOutput[]			= "
													<span class=\"input-group-btn\">
														<button class=\"btn btn-primary admin-color-setting my-position-trigger\">
															<i class=\"fa fa-compass\"></i>
														</button>
													</span>";

												$arrJavoOutput[]			= sprintf(
													"<input type=\"text\" id=\"%s\" class=\"%s\" value=\"%s\" placeholder=\"%s\">"
													, $element[ 'ID' ]
													, $element[ 'class' ]
													, $element[ 'value' ]
													, $element[ 'placeholder' ]
												);

											$arrJavoOutput[]				= "</div>";

											break;
										case 'price' :
											$arrJavoOutput[]				= "<div class=\"input-group\">";

												$arrJavoOutput[]			= sprintf( "
													<input type=\"number\" class=\"%s\" placeholder=\"%s\" value=\"%s\" data-min>
													<div class=\"input-group-addon\">%s</div>
													<input type=\"number\" class=\"%s\" placeholder=\"%s\" value=\"%s\" data-max> "
													, $element[ 'class' ][ 'min' ]
													, $element[ 'placeholder' ][ 'min' ]
													, $element[ 'value' ][ 'min' ]
													, esc_html__( "To", 'javohome' )
													, $element[ 'class' ][ 'max' ]
													, $element[ 'placeholder' ][ 'max' ]
													, $element[ 'value' ][ 'max' ]
												);

											$arrJavoOutput[]				= "</div>";

											break;
										case 'input' :
										case 'text' :
										case 'number' :
										default:
											$arrJavoOutput[]	= sprintf(
												"<input type=\"%s\" id=\"%s\" class=\"%s\" value=\"%s\" placeholder=\"%s\">"
												, $element[ 'type' ]
												, $element[ 'ID' ]
												, $element[ 'class' ]
												, $element[ 'value' ]
												, $element[ 'placeholder' ]
											);
									}
								$arrJavoOutput[]				= "</div>";
							} endif;
							$arrJavoOutput[]					= "</div>";
						$arrJavoOutput[]						= "</div>";
					$arrJavoOutput[]							= "</div>";
				}
			} endif;
			echo join( "\n", $arrJavoOutput );
			?>
		</div><!-- /.col-md-3 -->

		<div class="<?php echo apply_filters( 'jvfrm_home_' . $post->lava_type . '_map_list_content_column_class' , 'col-sm-9', $post ) ; ?>">
			<div class="row">
				<div id="results" class="col-md-12 col-xs-12">
					<div id="spaces" class="col-md-12 col-xs-12">
						<?php do_action( 'jvfrm_home_' . $post->lava_type . '_map_list_container_before', $post ); ?>
						<div id="space-0" class="space row" itemscope="" itemtype="http://schema.org/LodgingBusiness">
							<div id="javo-listings-wrapType-container" <?php echo $strListOutputClass;?>></div>
						</div><!--/.space row-->
					</div><!--/#spaces-->
					<button type="button" class="btn btn-default admin-color-setting btn-block javo-map-box-morebutton" data-javo-map-load-more>
						<i class="fa fa-spinner fa-spin"></i>
						<?php esc_html_e("Load More", 'javohome');?>
					</button>
					<?php do_action( 'jvfrm_home_' . $post->lava_type . '_map_list_container_after', $post ); ?>
				</div><!--/#results-->
			</div><!--/.row-->
		</div><!-- /.col-md-9 -->
	</div><!-- /.row -->
	<?php do_action( 'jvfrm_home_' . $post->lava_type . '_map_list_wrap_after', $post ); ?>
</div><!-- /.container-->