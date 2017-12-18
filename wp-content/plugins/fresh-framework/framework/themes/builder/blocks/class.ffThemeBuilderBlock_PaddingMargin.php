<?php

class ffThemeBuilderBlock_PaddingMargin extends ffThemeBuilderBlockBasic {
	const PARAM_TYPE = 'type';
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
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'padding-margin');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'p-m');
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

	private function _getDirections() {

		return array('t' =>'top', 'r' =>'right', 'b' =>'bottom', 'l' =>'left');

	}

	protected function _render( $query ) {

		if( $this->_queryIsEmpty() ) {
			return false;
		}

		$type = $this->getParam( ffThemeBuilderBlock_PaddingMargin::PARAM_TYPE );
		$rules = '';


		foreach( $this->_getDirections() as $oneDirection => $directionName ) {
			$value = $query->getWithoutComparationDefault( $oneDirection , null);

			if( $value != null ) {
				$rules .= $type . '-' . $directionName . ':' . $value . 'px;' . PHP_EOL;
			}
		}


		return $rules;
//		if( !empty( $rules ) )  {
//			$this->_getAssetsRenderer()->createCssRule()->addParamsString( $rules );
//		}
	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {
		$s->addOption( ffOneOption::TYPE_TEXT, 't', 'Top', '');
		$s->addOption( ffOneOption::TYPE_TEXT, 'r', 'Right', '');
		$s->addOption( ffOneOption::TYPE_TEXT, 'b', 'Bottom', '');
		$s->addOption( ffOneOption::TYPE_TEXT, 'l', 'Left', '');
//		$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', 'Here you can insert your HTML code. If you enable the PHP interpretation, then your code will be executed as a PHP.');
//		$s->addOption( ffOneOption::TYPE_TEXTAREA, 'html', '', '');
//		$s->addOption( ffOneOption::TYPE_CHECKBOX, 'use-as-php', 'Use as a PHP code instead of HTML', 0);
	}
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}