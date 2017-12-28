<?php
class Jvfrm_Home_Single_Post_Slider extends WP_Widget
{
	const IDS_JV_WG_TITLE	= 'widget_title';

	public $instanceDATA	= Array();
	public $strTitle		= 'Untitle';

	public function __construct(){

		parent::__construct(
			get_class( $this ),
			esc_html__( "[JAVO] Featured Listing Slider", 'Lavacode' )
		);
	}

	public function header(){ echo $this->args[ 'before_widget' ]; }
	public function footer(){ echo $this->args[ 'after_widget' ]; }

	public function getTitle( $strTitle='' ) {
		if( empty( $strTitle ) )
			$strTitle = $this->strTitle;
		return $this->args[ 'before_title' ] . $strTitle . $this->args[ 'after_title' ];
	}

	public function widget( $args=Array(), $instance ){

		if( !class_exists( 'JvfrmHome_ShortcodeParse' ) )
			return;

		$this->instanceDATA = $instance;
		$this->args			= $args;
		$this->render();
	}

	public function addParam( $args=Array() ) {
		$arrFieldset	= shortcode_atts(
			Array(
				'element'	=> 'input',
				'type'		=> 'text',
				'id'		=> 'noid',
				'label'		=> '',
				'class'		=> 'widefat',
			),$args
		);

		$arrFormDATA	= isset( $this->instanceDATA[ $arrFieldset['id'] ] ) ? $this->instanceDATA[ $arrFieldset['id'] ] : null;
		$strFieldID		= $this->get_field_id( $arrFieldset['id'] );
		$strFieldNAME	= $this->get_field_name( $arrFieldset['id'] );
		$strFieldVALUE	= esc_attr( $arrFormDATA );
		echo join( ' ',
			Array(
				'<p>',
					"<label for=\"{$strFieldID}\">{$arrFieldset['label']}</label>",
					'<input',
					"type=\"{$arrFieldset['type']}\"",
					"name=\"{$strFieldNAME}\"",
					"value=\"{$strFieldVALUE}\"",
					"id=\"{$strFieldID}\"",
					"class=\"{$arrFieldset['class']}\"",
					'>',
				'</p>',
			)
		);
	}

	public function getParam( $key, $default=false ){
		if( isset( $this->instanceDATA[ $key ] ) )
			$default = $this->instanceDATA[ $key ];
		return $default;
	}

	public function render()
	{
		// Widget Header
		$this->header();

		// Widget Title
		echo $this->getTitle( $this->getParam( self::IDS_JV_WG_TITLE ) );
		$this->body();
		// Widget Footer
		$this->footer();
	}

	public function body(){

		$strBlock	= 'jvfrm_home_slider2';
		$objBlock	= new $strBlock;
		echo $objBlock->output(
			Array(
				'post_type'					=> jvfrm_home_core()->slug,
				'featured_' . jvfrm_home_core()->slug => '1',
				'meta-author'				=> 'star',
				'module_contents_length'	=> 20
			)
		);
	}

	public function form( $instance ){
		$this->instanceDATA	= $instance;
		$this->addParam(
			Array(
				'id'	=> self::IDS_JV_WG_TITLE,
				'label'	=> esc_html__( "Widget Title", 'javohome' ),
			)
		);
	}
}