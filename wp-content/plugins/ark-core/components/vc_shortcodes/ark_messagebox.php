<?php

/* Message box
---------------------------------------------------------- */
vc_map(
	array(
		'name' => __( 'ARK - Message Box', 'js_composer' ),
		'base' => 'vc_ark_message',
		'icon' => 'icon-wpb-information-white',
		'wrapper_class' => 'alert',
		'category' => __( 'Content', 'js_composer' ),
		'description' => __( 'Notification box', 'js_composer' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Message box type', 'js_composer' ),
				'param_name' => 'color',
				'value' => array(
					__( 'Informational', 'js_composer' ) => 'alert-info',
					__( 'Warning', 'js_composer' ) => 'alert-warning',
					__( 'Success', 'js_composer' ) => 'alert-success',
					__( 'Error', 'js_composer' ) => "alert-danger"
				),
				'description' => __( 'Select message type.', 'js_composer' ),
				'param_holder_class' => 'vc_message-type'
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => 'messagebox_text',
				'heading' => __( 'Message text', 'js_composer' ),
				'param_name' => 'content',
				'value' => __( 'I am message box. Click edit button to change this text.', 'js_composer' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			)
		),
		'js_view' => 'VcMessageView'
	)
);

add_shortcode('vc_ark_message', 'vc_ark_message_func');
function vc_ark_message_func( $atts, $content ) {
	$atts_default = array(
		'color' => 'alert-info',
	);

	$atts = shortcode_atts($atts_default, $atts);

	$colorChanged = str_replace('-', ' ', $atts['color']);
	$colorChanged = str_replace('warning', 'notice', $colorChanged);
	$colorChanged = str_replace('danger','error', $colorChanged);


	$iconClass = 'ff-font-awesome4 icon-comments-o';

	if( $colorChanged == 'alert info' ) {
		$iconClass = 'ff-font-awesome4 icon-comments-o';
	} else if ( $colorChanged == 'alert success' ) {
		$iconClass = 'ff-font-awesome4 icon-check-circle';
	} else if ( $colorChanged == 'alert notice' ) {
		$iconClass = 'ff-font-awesome4 icon-exclamation-triangle';
	} else if ( $colorChanged == 'alert error' ) {
		$iconClass = 'ff-font-awesome4 icon-times-circle';
	}

	$toReturn = '';

	$toReturn .= '<div class="'.$colorChanged.'">';
	$toReturn .= '<i class="'.$iconClass.'"></i> ';
	$toReturn .= do_shortcode( $content );
	$toReturn .= '</div>';

	return $toReturn;
}