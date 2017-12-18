<?php

class ffThemeBuilderBlock_Styles extends ffThemeBuilderBlockBasic {
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
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'styles');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'st');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_SYSTEM, true);
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
		

	}



	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {
		$s->startTab('Styles', 'st', false, true);
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Style Group(s)');

                $s->addOptionNL( ffOneOption::TYPE_SELECT_STYLES, 'styles', 'Styles', '')
//                    ->addSelectValue('Styl Margin ty Zmrde', 'margin-style')
//                    ->addSelectValue('Styl Padding ty kurvo', 'padding-style')
                ;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);



		$s->addElement( ffOneElement::TYPE_TABLE_END);
		$s->endTab();
	}



	private function _getBreakpoints() {
		$breakpoints = array(
			'xs' => 'Phone (XS)',
			'sm' => 'Tablet (SM)',
			'md' => 'Laptop (MD)',
			'lg' => 'Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;',
		);

		return $breakpoints;
	}

	private function _getPositions() {
		$positions = array(
			't' => 'top',
			'r' => 'right',
			'b' => 'bottom',
			'l' => 'left'
		);

		return $positions;
	}



/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/


}