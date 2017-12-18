<?php

class ffOptionsStructureHelper extends ffBasicObject {
	/**
	 * @var ffOneStructure
	 */
	private $_s = null;

	public function setStructure( $structure ) {
		$this->_s = $structure;
	}

/**********************************************************************************************************************/
/* HIDING BOXES
/**********************************************************************************************************************/
	public function startHidingBoxParent() {
		$s =  $this->_s;
		$s->addElement(ffOneElement::TYPE_HTML, '', '<div class="ff-hiding-box-normal-parent">');
	}

	public function endHidingBoxParent() {
		$s =  $this->_s;
		$s->addElement(ffOneElement::TYPE_HTML, '', '</div>');
	}

	public function startHidingBox( $optionName, $optionValue, $valueNotEqual = false, $parentSelector = null ) {
		$s = $this->_s;

		if( !is_array( $optionValue ) ) {
			$optionValueArray = array();
			$optionValueArray[] = $optionValue;
		} else {
			$optionValueArray = $optionValue;
		}

		$optionValueString = implode(',', $optionValueArray);


		$operator = $valueNotEqual ? 'not-equal' : 'equal';

		$parentSelectorString = '';
		if( $parentSelector != null ) {
			$parentSelectorString = ' data-parent-selector="' . esc_attr( $parentSelector) .'" ';
		}

		$s->addElement(ffOneElement::TYPE_HTML, '', '<div class="ff-hiding-box-normal" '. $parentSelectorString.' data-option-name="'. $optionName .'" data-option-value="'.($optionValueString).'" data-option-operator="'.$operator.'">');
	}

	public function endHidingBox() {
		$s = $this->_s;

		$s->addElement(ffOneElement::TYPE_HTML, '', '</div>');
	}
}