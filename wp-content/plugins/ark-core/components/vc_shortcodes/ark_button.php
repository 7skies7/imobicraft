<?php


vc_map(
	array(
		'name' => 'ARK - ' . __( 'Button', 'js_composer' ),
		'base' => 'vc_ark_button',
		'icon' => 'icon-wpb-ui-button',
		'category' => array( __( 'Content', 'js_composer' ) ),
		'description' => __( 'Eye catching button', 'js_composer' ),
		'params' => array(
			array(
				'type' => 'vc_link',
				'heading' => __( 'URL (Link)', 'js_composer' ),
				'param_name' => 'link',
				'description' => __( 'Button link.', 'js_composer' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Use icon', 'js_composer' ),
				'param_name' => 'use_icon',
				'value' => array(
					__( 'Do not use', 'js_composer') => '',
					__( 'Use',  'js_composer') => '1',
				),
				'std' => '',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'vc_ff_icon_picker',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Text on the button', 'js_composer' ),
				'holder' => 'button',
				'class' => 'vc_btn',
				'param_name' => 'title',
				'value' => __( 'Text on the button', 'js_composer' ),
				'description' => __( 'Text on the button.', 'js_composer' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'js_composer' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Squared', 'js_composer' ) => 'squared',
					__( 'Rounded', 'js_composer' ) => 'rounded',
					__( 'Outlined', 'js_composer' ) => 'outlined',
					__( 'Square Outlined', 'js_composer' ) => 'square_outlined',
				),
				'std' => 'squared',
				'description' => __( 'Button style.', 'js_composer' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Color', 'js_composer' ),
				'param_name' => 'color',
				'value' => array(
					__( 'Black', 'js_composer' ) => 'black',
					__( 'Dark transparent', 'js_composer' ) => 'glass',
					__( 'White', 'js_composer' ) => 'white',
					__( 'Juicy pink', 'js_composer' ) => 'juicy_pink',
					__( 'Grey', 'js_composer' ) => 'grey',
				),
				'std' => 'black',
				'description' => __( 'Button color.', 'js_composer' ),
				'param_holder_class' => 'vc_colored-dropdown'
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Size', 'js_composer' ),
				'param_name' => 'size',
				'value' => array(
					__( 'Mini',   'js_composer') => 'xs',
					__( 'Small',  'js_composer') => 'sm',
					__( 'Normal', 'js_composer') => 'md',
					__( 'Large',  'js_composer') => 'lg',
				),
				'std' => 'md',
				'description' => __( 'Button size.', 'js_composer' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			)
		),
	)
);

add_shortcode('vc_ark_button', 'vc_ark_button_func');
function vc_ark_button_func( $atts ) {

	extract( shortcode_atts( array(
		'link' => '',
		'use_icon' => '',
		'vc_ff_icon_picker' => '',
		'title' => __( 'Text on the button', "js_composer" ),
		'color' => '',
		'style' => 'squared',
		'size' => 'md',
		'el_class' => ''
	), $atts ) );

	$link = ( $link == '||' ) ? '' : $link;
	$link = vc_build_link( $link );
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'];
	if( !empty( $a_target ) ){
		$a_target = ' target="'.esc_attr($a_target).'"';
	}

	$css_class = ' btn btn-mod ';

	if( !empty($use_icon) ){
		if( 'lg' == $size ){
			$css_class .= ' btn-icon ';
		}
	}

	switch ($size) {
		case 'lg': $css_class .= ' btn-large '; break;
		case 'md': $css_class .= ' btn-medium '; break;
		case 'sm': $css_class .= ' btn-small '; break;
		case 'xs': $css_class .= ' '; break;
	}

	// btn-circle
	if( ( 'rounded' == $style ) || 'outlined' == $style ){
		$css_class .= ' btn-circle ';
	}

	// btn-border
	switch ($style) {
		case 'outlined':
		case 'square_outlined':
			switch ($color){
				case 'juicy_pink' : $css_class .= ' btn-border-c '; break;
				case 'white'      : $css_class .= ' btn-border-w '; break;
				case 'glass'      : $css_class .= ' btn-glass '   ; break;
				case 'grey'       : $css_class .= ' btn-gray '    ; break;
				default           : $css_class .= ' btn-border '  ;
			}
			break;

		default:
			switch ($color){
				case 'juicy_pink': $css_class .= ' btn-color '; break;
				case 'glass'     : $css_class .= ' btn-glass '; break;
				case 'grey'       : $css_class .= ' btn-gray '    ; break;
				case 'white'     : $css_class .= ' btn-w ';
			}
	}

	$css_class .= ' '.$el_class;

	$output = '';

	$output .= '<a class="' . esc_attr( trim( $css_class ) ) .'" href="'. $a_href .'"';
	$output .= ' title="'. esc_attr( $a_title ) . '"'. $a_target . '>';
	if( !empty($use_icon) ){
		$output .= '<span><i class="'.$atts['vc_ff_icon_picker'].'"></i></span> ';
	}
	$output .= do_shortcode( $title );
	$output .= '</a>';

	return $output;
}
