<?php


vc_map(
	array(
		'name' => 'ARK - ' . __( 'Progress Bar', 'js_composer' ),
		'base' => 'vc_ark_progress_bar',
		'icon' => 'icon-wpb-graph',
		'category' => __( 'Content', 'js_composer' ),
		'description' => __( 'Show current post id', 'js_composer' ),
		'params' => array(
			array(
				'type' => 'exploded_textarea',
				'heading' => __( 'Graphic values', 'js_composer' ),
				'param_name' => 'values',
				'description' => __( 'Input graph values, titles and color here. Divide values with linebreaks (Enter). Example: 90|Development|#e75956', 'js_composer' ),
				'value' => "90|Development,80|Design,70|Marketing"
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'js_composer' ),
				'param_name' => 'bgcolor',
				'value' => array(
					'Black, thin' => 'tpl-progress',
					'Color, thin' => 'tpl-progress progress-color',
					'Black Background' => 'tpl-progress-alt',
					'Color Background' => 'progress-color tpl-progress-alt',
				),
				'description' => __( 'Select bar background color.', 'js_composer' ),
				'admin_label' => true
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			)
		)
	)
);

add_shortcode('vc_ark_progress_bar', 'vc_ark_progress_bar_func');
function vc_ark_progress_bar_func( $atts ) {
	$atts_default = array(
		'values' => '90|Bar',
		'units' => '%',
		'bgcolor' => 'tpl-progress',
	);
	$atts = shortcode_atts($atts_default, $atts);

	$output = '';

	$splitedBars = explode(',', $atts['values']);

	foreach( $splitedBars as $oneBar ) {

		$oneBarSplited = explode('|', $oneBar );

		$number = $oneBarSplited[0];
		$value = $oneBarSplited[1];

		$output .= '<div class="progress';
		$output .= ' '.$atts['bgcolor'];
		$output .= '">';
		$output .= '<div class="progress-bar" role="progressbar" aria-valuenow="'.$number.'" aria-valuemin="0" aria-valuemax="100">';
		if( ( 'tpl-progress-alt' == $atts['bgcolor'] ) || ( 'progress-color tpl-progress-alt' == $atts['bgcolor'] ) ){
			$output .= $value.', '.' <span>'.$number.$atts['units'].'</span>';
		}else{
			$output .= $value.', '.$atts['units'].' <span>'.$number.'</span>';
		}
		$output .= '</div>';
		$output .= '</div>';
	}

	return $output;
}
