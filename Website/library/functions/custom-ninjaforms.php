<?php
/**
 * Lava plugin custom code for Ninja form plugin
 **/

// Register Lava Sidebar

add_action('admin_init', 'lava_ninja_forms_register_sidebar_layout_fields');

function lava_ninja_forms_register_sidebar_layout_fields(){
	$args = array(
		'name' => esc_html__( 'Lava Fields', 'ninja-forms' ),
		'page' => 'ninja-forms',
		'tab' => 'builder',
		'display_function' => 'ninja_forms_sidebar_display_fields'
	);

	if( function_exists( 'ninja_forms_register_sidebar' ) )
		ninja_forms_register_sidebar('lava_fields', $args);
}



//Register Lava Author Email
add_action('init', 'lava_author_email_field_register');

function lava_author_email_field_register(){
	$args = array(
		'name' => 'Author Email',
		'edit_options' => array(
			array(
				'type' => 'select',
				'name' => 'default_value1',
				'label'   => esc_html__( 'author email', 'ninja-forms' ),
				'width' => 'wide',
				'class' => 'widefat33'
			),
		),
		'display_function' => 'ninja_forms_sidebar_display_lava_get_author_email',
		'sub_edit_function' => '',
		'group' => 'lava_fields',
		'edit_label' => true,
		'edit_label_pos' => true,
		'edit_req' => true,
		'edit_custom_class' => true,
		'edit_help' => true,
		'edit_meta' => false,
		'sidebar' => 'lava_fields',
		'edit_conditional' => true,
		'conditional' => array(
			'value' => array(
				'type' => 'select',
			),
		),
	);

	if( function_exists( 'ninja_forms_register_field' ) )
		ninja_forms_register_field('_author-email', $args);
}


function ninja_forms_sidebar_display_lava_get_author_email($field_id, $data, $form_id = ''){
	//global $ninja_forms_fields, $current_tab;

	$field_class = ninja_forms_get_field_class( $field_id, $form_id );
	if(isset($data['default_value'])){
		$default_value = $data['default_value'];
	}else{
		$default_value = '';
	}

	$lava_author_id= get_the_author_meta("ID");
	//echo 'author='.$lava_author_id.'<br/>';
	$lava_author_email=get_the_author_meta('user_email',$lava_author_id);
	//echo 'author='.$lava_author_email.'<br/>';
	?>
	<input id="ninja_forms_field_<?php echo sanitize_html_class( $field_id );?>" data-mask="" data-input-limit="" data-input-limit-type="char" data-input-limit-msg="" name="ninja_forms_field_<?php echo $field_id;?>" placeholder="<?php esc_attr_e( "Your email address", 'javohome' ); ?>" class="ninja-forms-field  ninja-forms-req email " value="<?php echo esc_attr( $lava_author_email ); ?>" rel="<?php echo esc_html( $field_id );?>" type="text" style="display:none;">

	<?php
}



//Register Javo Mypage PM Email
add_action('init', 'lava_pm_email_field_register');

function lava_pm_email_field_register(){
	$args = array(
		'name' => 'PM Email',
		'edit_options' => array(
			array(
				'type' => 'select',
				'name' => 'default_value1',
				'label'   => esc_html__( 'PM email', 'ninja-forms' ),
				'width' => 'wide',
				'class' => 'widefat33'
			),
		),
		'display_function' => 'ninja_forms_sidebar_display_lava_get_pm_email',
		'sub_edit_function' => '',
		'group' => 'lava_fields',
		'edit_label' => true,
		'edit_label_pos' => true,
		'edit_req' => true,
		'edit_custom_class' => true,
		'edit_help' => true,
		'edit_meta' => false,
		'sidebar' => 'lava_fields',
		'edit_conditional' => true,
		'conditional' => array(
			'value' => array(
				'type' => 'select',
			),
		),
	);

	if( function_exists( 'ninja_forms_register_field' ) )
		ninja_forms_register_field('_pm-email', $args);
}


function ninja_forms_sidebar_display_lava_get_pm_email($field_id, $data, $form_id = ''){
	//global $ninja_forms_fields, $current_tab;

	$field_class = ninja_forms_get_field_class( $field_id, $form_id );
	if(isset($data['default_value'])){
		$default_value = $data['default_value'];
	}else{
		$default_value = '';
	}

	$lava_pm_id= get_the_author_meta("ID");
	echo 'pm='.$lava_pm_id.'<br/>';
	$lava_pm_email=get_the_author_meta('user_email',$lava_pm_id);
	echo 'pm='.$lava_pm_email.'<br/>';
	?>
	<input id="ninja_forms_field_<?php echo sanitize_html_class( $field_id );?>" data-mask="" data-input-limit="" data-input-limit-type="char" data-input-limit-msg="" name="ninja_forms_field_<?php echo $field_id;?>" placeholder="<?php esc_attr_e( "Your email address", 'javohome' ); ?>" class="ninja-forms-field  ninja-forms-req email " value="<?php echo esc_attr( $lava_pm_email ); ?>" rel="<?php echo esc_html( $field_id );?>" type="text" style="display:none;">

	<?php
}