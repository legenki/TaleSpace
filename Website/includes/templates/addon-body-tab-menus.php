<?php
$arrCoreSingleTabMenus = apply_filters(
	'jvfrm_home_' . get_post_type() . '_single_tab_menus',
	Array(
		'info' => Array(
			'active' => true,
			'label' => esc_html__( "Information", 'javohome' ),
			'icon' => "jvd-icon-website_2"
		),
		'gallery' => Array(
			'label' => esc_html__( "Gallery", 'javohome' ),
			'icon' => "jvd-icon-multiple_image"
		),
	)
);
if( !empty( $arrCoreSingleTabMenus ) )
	foreach( $arrCoreSingleTabMenus as $strTabID => $strTabMeta )
		printf(
			'<li class="js-tab%1$s"><a href="%2$s" role="tab" data-toggle="tab"><i class="%4$s"></i><span>%3$s</span></a></li>',
			( isset( $strTabMeta[ 'active' ] ) ? ' active' : false ),
			'#' . $strTabID,
			$strTabMeta[ 'label' ],
			$strTabMeta[ 'icon' ]
		);
