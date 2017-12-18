<?php

class ffBlAnimation extends ffThemeBuilderBlockBasic {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	protected function _init() {
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'animation');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'anm');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, true);
	}
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/


	protected function _render( $query ) {
		if( $this->_queryIsEmpty() ) {
			return false;
		}

		$ret = '';
		$data_type = $query->get('type');
		$data_duration = $query->get('duration');
		$data_delay = $query->get('delay');
		
		$ret .= '';
		
		if( !empty($data_type) ){
			$ret .= ' data-fg-wow="'. esc_attr($data_type) .'" ';
		} else {
			// if animation type is not set then do nothing and exit
			return '';
		}

		if ( !empty($data_duration) ){
			$ret .= ' data-wow-duration="'. esc_attr($data_duration) .'s" ';
		}

		if ( !empty($data_delay) ){
			$ret .= ' data-wow-delay="'. esc_attr($data_delay) .'s" ';
		}

		if( $this->getParam('get-data') ){
			return $ret;
		} else {
			echo ark_wp_kses( $ret );
		}

		return '';
	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$optType = $s->addOptionNL( ffOneOption::TYPE_SELECT, 'type', '', '')
				->addSelectValue( '', '')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Reveal Animation', 'ark' ) ) )
			;


			$possibleOptValues = array(
				'bounce' ,
				'flash' ,
				'pulse' ,
				'rubberBand' ,
				'shake' ,
				'swing' ,
				'tada' ,
				'wobble' ,
				'bounceIn' ,
				'bounceInDown' ,
				'bounceInLeft' ,
				'bounceInRight' ,
				'bounceInUp' ,
				'bounceOut' ,
				'bounceOutDown' ,
				'bounceOutLeft' ,
				'bounceOutRight' ,
				'bounceOutUp' ,
				'fadeIn' ,
				'fadeInDown' ,
				'fadeInDownBig' ,
				'fadeInLeft' ,
				'fadeInLeftBig' ,
				'fadeInRight' ,
				'fadeInRightBig' ,
				'fadeInUp' ,
				'fadeInUpBig' ,
				'fadeOut' ,
				'fadeOutDown' ,
				'fadeOutDownBig' ,
				'fadeOutLeft' ,
				'fadeOutLeftBig' ,
				'fadeOutRight' ,
				'fadeOutRightBig' ,
				'fadeOutUp' ,
				'fadeOutUpBig' ,
				'animated.flip' ,
				'flipInX' ,
				'flipInY' ,
				'flipOutX' ,
				'flipOutY' ,
				'lightSpeedIn' ,
				'lightSpeedOut' ,
				'rotateIn' ,
				'rotateInDownLeft' ,
				'rotateInDownRight' ,
				'rotateInUpLeft' ,
				'rotateInUpRight' ,
				'rotateOut' ,
				'rotateOutDownLeft' ,
				'rotateOutDownRight' ,
				'rotateOutUpLeft' ,
				'rotateOutUpRight' ,
				'hinge' ,
				'rollIn' ,
				'rollOut' ,
				'zoomIn' ,
				'zoomInDown' ,
				'zoomInLeft' ,
				'zoomInRight' ,
				'zoomInUp' ,
				'zoomOut' ,
				'zoomOutDown' ,
				'zoomOutLeft' ,
				'zoomOutRight' ,
				'zoomOutUp' ,
				'slideInDown' ,
				'slideInLeft' ,
				'slideInRight' ,
				'slideInUp' ,
				'slideOutDown' ,
				'slideOutLeft' ,
				'slideOutRight' ,
				'slideOutUp' ,
			);

			foreach ($possibleOptValues as $possibleValue) {
				$possibleValueTitle = str_replace('-', ' ', $possibleValue);
				$possibleValueTitle = ucfirst( $possibleValueTitle );
				$optType->addSelectValue( $possibleValueTitle, $possibleValue );
			}


			$s->addOptionNL(ffOneOption::TYPE_TEXT, 'duration', '', '')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Animation Duration (in seconds)', 'ark' ) ) );
			$s->addOptionNL(ffOneOption::TYPE_TEXT, 'delay', '', '')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Animation Delay (in seconds)', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_TABLE_END );
	}
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}