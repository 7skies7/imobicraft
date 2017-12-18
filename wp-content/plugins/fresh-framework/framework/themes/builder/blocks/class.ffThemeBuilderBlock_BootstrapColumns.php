<?php

class ffThemeBuilderBlock_BootstrapColumns extends ffThemeBuilderBlockBasic {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	const PARAM_RETURN_AS_STRING = 'return_as_string';
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	protected function _init() {
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'bootstrap-columns');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'bootstrap-columns');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true);
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

		$classes = array();

		foreach( array('xs', 'sm', 'md', 'lg') as $bp ){

			$col = $query->getWithoutComparationDefault($bp, $bp);

			if( $col != 'unset' ){
				$classes[] = 'col-' . $bp . '-' . $col;
			}
		}

		if( $this->getParam( ffThemeBuilderBlock_BootstrapColumns::PARAM_RETURN_AS_STRING, true ) ) {
			return implode(' ', $classes);
		} else {
			return $classes;
		}
	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$params = $this->getParam('default');

		$toggleLabel = 'Column Width';
		if( $this->getParam('use-toggle') ){
			if( $this->getParam('toggle') ){
				$toggleLabel = $this->getParam('toggle');
			}
		}

		if( isset($params['xs']) ) {$colXS = $params['xs'];} else {$colXS = '12';}
		if( isset($params['sm']) ) {$colSM = $params['sm'];} else {$colSM = 'unset';}
		if( isset($params['md']) ) {$colMD = $params['md'];} else {$colMD = 'unset';}
		if( isset($params['lg']) ) {$colLG = $params['lg'];} else {$colLG = 'unset';}

		$breakpoints = array(
			'xs' => 'Phone (XS)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			'sm' => 'Tablet (SM)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			'md' => 'Laptop (MD)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			'lg' => 'Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
		);


		if( $this->getParam('use-toggle') ) {
			$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', $toggleLabel);
		}

			$default_values = array(
				'xs' => $colXS,
				'sm' => $colSM,
				'md' => $colMD,
				'lg' => $colLG,
			);

			$prev_bp = '';
			foreach( $breakpoints as $bp => $bp_title ){

				$opt = $s->addOption(ffOneOption::TYPE_SELECT, $bp, $bp_title, $default_values[$bp] );
				if ( 'xs' != $bp ){
					$opt->addSelectValue($prev_bp, 'unset');
				}
				$opt->addSelectNumberRange(1,12);

				$s->addElement(ffOneElement::TYPE_HTML, '', ' / 12');
				$s->addElement( ffOneElement::TYPE_NEW_LINE );

				$prev_bp = 'Inherit';

			}

		if( $this->getParam('use-toggle') ) {
			$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
		}

	}
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}