<?php

class ffThemeBuilderOptionsExtender extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	/**
	 * @var ffThemeBuilderBlockFactory
	 */
	private $_themeBuilderBlockFactory = null;

	/**
	 * @var ffThemeBuilderBlockManager
	 */
	private $_themeBuilderBlockManager = null;

	private $_injectBlocksWithoutReference = false;

	/**
	 * @var ffOneStructure
	 */
	private $_s = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

	public function setInjectBlocksWithoutReference( $value ) {
		$this->_injectBlocksWithoutReference = $value;
	}

	public function getData() {
		return $this->_s->getData();
	}
	public function setStructure( ffOneStructure $s ) {
		$this->_s = $s;
	}

    public function startRepVariableSection( $id  ) {
		$section = $this->_s->startSection($id,ffOneSection::TYPE_REPEATABLE_VARIABLE)
			->addParam('can-be-empty', true)
			->addParam('work-as-accordion', true)
			->addParam('all-items-opened', true)
		;
		return $section;
	}



	public function endRepVariableSection() {
		$s = $this->_s;

		$this->startRepVariationSection('html', 'HTML')
			->addParam('hide-default', true);
				$this->_getBlock(ffThemeBuilderBlock::HTML)->injectOptions( $this );
		$this->endRepVariationSection();

		$s->endSection();
	}

	private function _insertSystemSettingsModal( $printOpenButton = false) {
		$this->startModal('Advanced Options', 'ff-advanced-options')
			->addParam('print-open-button', $printOpenButton);
			$this->startTabs();

                $this->_getBlock( ffThemeBuilderBlock::STYLES )
                    ->setParam(ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $this->_injectBlocksWithoutReference)
                    ->injectOptions( $this );
//				$this->startTab('Box Model', 'b-m', true);
					$this->_getBlock( ffThemeBuilderBlock::BOX_MODEL)
						->setParam( ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $this->_injectBlocksWithoutReference )
						->injectOptions( $this );
//				$this->endTab();

//				$this->startTab('Typography', 'clrs');
					$this->_getBlock( ffThemeBuilderBlock::COLORS)
						->setParam( ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $this->_injectBlocksWithoutReference )
						->injectOptions( $this );
//				$this->endTab();

//				$this->startTab('element.style', 'a-t');
					$this->_getBlock( ffThemeBuilderBlock::ADVANCED_TOOLS )
						->setParam( ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $this->_injectBlocksWithoutReference )
						->injectOptions( $this );
//				$this->endTab();

//				$this->startTab('Custom Code', 'cc');
					$this->_getBlock( ffThemeBuilderBlock::CUSTOM_CODES )
						->setParam( ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $this->_injectBlocksWithoutReference )
						->injectOptions( $this );
//				$this->endTab();
			$this->endTabs();
		$this->endModal();
	}

	public function startCssWrapper( $cssClass ) {
		$this->_s->addElement (ffOneElement::TYPE_HTML,'', '<div class="ff-css-wrapper ff-css-wrapper-start" data-type="start" data-css-class="'.$cssClass.'"></div>');
	}

	public function endCssWrapper() {
		$this->_s->addElement (ffOneElement::TYPE_HTML,'', '<div class="ff-css-wrapper ff-css-wrapper-end" data-type="end"></div>');
	}

	public function addAdvancedToolsButton( $id, $name ) {
		$s = $this->_s;

		$s->startSection( $id );
			$s->addElement(ffOneElement::TYPE_HTML, '', '<div class="ff-advanced-tools-opener-button">' . $name . '</div>');
			$this->_insertSystemSettingsModal();
		$s->endSection();
	}

	public function startAdvancedToggleBox ( $id, $name ) {
		$s = $this->_s;

		$s->addElement( ffOneElement::TYPE_TOGGLE_BOX_START, $id, $name  )
			->addParam('show-advanced-tools', true)
			->addParam('is-opened', true)
		;

		$s->startSection( $id );

		$this->_insertSystemSettingsModal();

		// $s->addElement(ffOneElement::TYPE_DESCRIPTION, '', 'This is advanced toggle box. You can apply your custom CSS styles here, by the edit (pen) icon');
	}

	public function insertSystemSettingsModal( $printOpenButton = false ) {
		return $this->_insertSystemSettingsModal( $printOpenButton );
	}

	public function endAdvancedToggleBox() {
		$s = $this->_s;

		$s->endSection();
		$s->addElement( ffOneElement::TYPE_TOGGLE_BOX_END );
	}

	public function startHidingBoxParent() {
		$s =  $this->_s;
		$s->addElement(ffOneElement::TYPE_HTML, '', '<div class="ff-hiding-box-parent">');
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

		$s->addElement(ffOneElement::TYPE_HTML, '', '<div class="ff-hiding-box" '. $parentSelectorString.' data-option-name="'. $optionName .'" data-option-value="'.($optionValueString).'" data-option-operator="'.$operator.'">');
	}

	public function endHidingBox() {
		$s = $this->_s;

		$s->addElement(ffOneElement::TYPE_HTML, '', '</div>');
	}

	/**
	 * @param $id
	 * @param $name
	 * @return $this ffOneSection
	 */
	public function startRepVariationSection( $id, $name, $insertSystemSettings = true ) {
		$s = $this->_s;
		$section = $s->startSection($id, ffOneSection::TYPE_REPEATABLE_VARIATION)->addParam('section-name', $name )->addParam('show-advanced-tools', $insertSystemSettings)->addParam('hide-default', true);

		if( $insertSystemSettings ) {
			$this->_insertSystemSettingsModal();
		}
		return $section;
	}

	public function endRepVariationSection() {
		$this->_s->endSection();
	}
	

	public function startReferenceSection( $id, $type = null ) {
		return $this->_s->startReferenceSection( $id, $type );
	}

	public function endReferenceSection() {
		return $this->_s->endReferenceSection();
	}

	public function addElement($type, $id = NULL, $name = NULL){
		return $this->_s->addElement( $type, $id, $name );
	}

	public function addOption($type, $id = NULL, $label = NULL, $content = NULL){

		if( $type == ffOneOption::TYPE_COLOR_PICKER_WITH_LIB && $content == null ) {
			$content = '';
		}

		return $this->_s->addOption( $type, $id, $label, $content );
	}

	public function addOptionNL($type, $id = NULL, $label = NULL, $content = NULL){

		if( $type == ffOneOption::TYPE_COLOR_PICKER_WITH_LIB && $content == null ) {
			$content = '';
		}

		return $this->_s->addOptionNL( $type, $id, $label, $content );
	}

	public function addTinyMCE( $id, $label, $content ) {
		$s = $this->_s;

		$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ff-tinymce-wrapper">');
			$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ff-tinymce-status-holder" style="display:none;">');
				$s->addOption(ffOneOption::TYPE_TEXT, $id . '-tinymce-enable', '', 0)
					->addParam('class', $id . '-tinymce-enable' );
			$s->addElement( ffOneElement::TYPE_HTML, '', '</div>');

			$option = $s->addOption(ffOneOption::TYPE_TINYMCE, $id, $label, $content );
		$s->addElement( ffOneElement::TYPE_HTML, '', '</div>');

		return $option;
	}


	public function startSection($id, $type = NULL){
		return $this->_s->startSection( $id, $type );
	}

	public function endSection(){
		$this->_s->endSection();
	}




    public function startTabs() {
		$s = $this->_s;

        // start tab
        $s->addElement(ffOneElement::TYPE_HTML,'', '<div class="ffb-modal__tabs">');

            // empty header, will be added lately
            $s->addElement(ffOneElement::TYPE_HTML,'', '<div class="ffb-modal__tab-headers clearfix">');
            $s->addElement(ffOneElement::TYPE_HTML,'', '</div>');

            // start tab content
            $s->addElement(ffOneElement::TYPE_HTML,'', '<div class="ffb-modal__tab-contents clearfix">');
    }

    public function endTabs() {
		$s = $this->_s;

            // end contents
            $s->addElement(ffOneElement::TYPE_HTML,'', '</div>');

        // end tabs
        $s->addElement(ffOneElement::TYPE_HTML,'', '</div>');
    }

	public function getOptionsStructureHelper() {
		return $this->_s->getOptionsStructureHelper();
	}


    public function startTab( $name, $id = null, $isActive = false, $isSystemTab = false ) {


		$s = $this->_s;

        $headerActive = '';
        $contentActive = '';

        if( $isActive ) {
            $headerActive = ' ffb-modal__tab-header--active';
            $contentActive = ' ffb-modal__tab-content--active';
        }

	    $contentIsSystem = '';
	    if( $isSystemTab ) {
		    $contentIsSystem = ' ffb-modal__content-system ';
	    }

        // Header
        $s->addElement(ffOneElement::TYPE_HTML,'', '<div class="ffb-modal__tab-header '.$headerActive.'" data-id="'. $id . '" data-tab-header-name="'.$name.'">'.$name.'</div>');

        // Content
        $s->addElement(ffOneElement::TYPE_HTML,'', '<div class="ffb-modal__tab-content '.$contentActive.' '.$contentIsSystem.'" data-id="'. $id . '" data-tab-content-name="'.$name.'">');
            $s->addElement(ffOneElement::TYPE_HTML,'', '<div class="ffb-modal__content--options ffb-options">');


    }

    public function endTab() {
			$this->_s->addElement(ffOneElement::TYPE_HTML,'', '</div>'); // end content--options
		$this->_s->addElement(ffOneElement::TYPE_HTML,'', '</div>'); // end content
    }


    public function startModal( $modalName, $modalClass ) {
		$this->_s->addElement( ffOneElement::TYPE_NOT_PRINT_START );

		$modalStart =$this->_s->addElement(ffOneElement::TYPE_MODAL_START,'', '')
			->addParam('modal-class', $modalClass)
			->addParam('modal-name', $modalName )
		; // end content--options

	    return $modalStart;
    }

    public function endModal() {

	    $this->_s->addElement(ffOneElement::TYPE_MODAL_END,'', '');


	    $this->_s->addElement( ffOneElement::TYPE_NOR_PRINT_END);
    }

	public function getStructure() {
		return $this->_s;
	}
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
	protected function _getBlock( $blockClassName ) {
		return $this->_getThemeBuilderBlockManager()->getBlock( $blockClassName );
	}
/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	/**
	 * @return ffThemeBuilderBlockFactory
	 */
	private function _getThemeBuilderBlockFactory()
	{
		if( $this->_themeBuilderBlockFactory == null ) {

			$this->_themeBuilderBlockFactory = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderBlockFactory();
		}
		return $this->_themeBuilderBlockFactory;
	}

	/**
	 * @return ffThemeBuilderBlockManager
	 */
	private function _getThemeBuilderBlockManager() {
		if( $this->_themeBuilderBlockManager == null ) {
			$this->_themeBuilderBlockManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderBlockManager();
		}

		return $this->_themeBuilderBlockManager;
	}
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS 
/**********************************************************************************************************************/
}