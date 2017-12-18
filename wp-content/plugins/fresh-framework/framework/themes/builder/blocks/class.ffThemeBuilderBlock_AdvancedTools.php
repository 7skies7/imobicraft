<?php

class ffThemeBuilderBlock_AdvancedTools extends ffThemeBuilderBlockBasic {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	const PARAM_RETURN_AS_STRING = 'return_as_string';
	const PARAM_WRAP_BY_MODAL = 'wrap_by_modal';
	const PARAM_CSS_CLASS = 'css_class';
	const PARAM_ATTRIBUTE ='attribute';
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	protected $_attributes = array();
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	protected function _init() {
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'advanced-tools');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'a-t');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_SYSTEM, true);
	}
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function wrapByModal() {
		$this->setParam( ffThemeBuilderBlock_AdvancedTools::PARAM_WRAP_BY_MODAL, true );
		return $this;
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	protected function _reset() {
		$this->_attributes = array();
	}



	private function _addUnitToInteger( $value, $unit = 'px' ) {
		if( is_numeric( $value ) ) {
			return $value . $unit;
		} else {
			return $value;
		}
	}

	protected function _setInlineAttributes( $options, $query, $addUnits = false ) {

		$element = $this->_getAssetsRenderer()->getElementHelper();


		foreach ($options as $oneOption) {
			$value = $query->getWithoutComparationDefault($oneOption, '');

			if (!empty($value) || $value === 0 || $value === '0' ) {
				if( $addUnits ) {
					$value = $this->_addUnitToInteger( $value );
				}

				$style = $oneOption . ':' . $value . '; ';
				$element->addAttribute('style', $style);
			}
		}
	}

	protected function _render( $query ) {
		if( $this->_queryIsEmpty() ) {
			return false;
		}

		$element = $this->_getAssetsRenderer()->getElementHelper();

		/*----------------------------------------------------------*/
		/* ID
		/*----------------------------------------------------------*/
		$id = $query->getWithoutComparationDefault('id', '');

		if( !empty( $id ) ) {
			$element->setAttribute('id', $id );
		}

		/*----------------------------------------------------------*/
		/* CLASS
		/*----------------------------------------------------------*/
		$class = $query->getWithoutComparationDefault('cls', '');

		if( !empty( $class ) ) {
			$element->addAttribute('class', $class );
		}


		/*----------------------------------------------------------*/
		/* TYPOGRAPHY
		/*----------------------------------------------------------*/
		if( $query->exists('typography') ) {
			$subQuery = $query->get('typography');

			$options = array();


			$options[] = 'line-height';
			$options[] = 'font-weight';
			$options[] = 'font-style';
//			$options[] = 'font-family';
			$options[] = 'text-transform';
			$options[] = 'text-decoration';
			$options[] = 'text-align';

			$this->_setInlineAttributes( $options, $subQuery );

			$options = array();
			$options[] = 'font-size'; //px
			$this->_setInlineAttributes( $options, $subQuery, true );

			$googleFontFamily = $subQuery->getWithoutComparationDefault('google-font-family', '');
			$userFontFamily = $subQuery->getWithoutComparationDefault('font-family', '');
			$fontFamilyString = '';

			$fontFamilyArray = array();

			if( !empty( $googleFontFamily ) ) {
				$fontFamilyArray[] = $googleFontFamily;
			}

			if( !empty( $userFontFamily ) ) {
				$fontFamilyArray[] = $userFontFamily;
			}

			if( !empty( $fontFamilyArray ) ) {
				$fontFamilyArray[] = 'Arial';
				$fontFamilyArray[] = 'sans-serif';
				$fontFamilyString = implode(', ', $fontFamilyArray );
				$fontFamilyString = 'font-family: ' . $fontFamilyString .';';
			}

			if( !empty( $fontFamilyString ) ) {
				$element = $this->_getAssetsRenderer()->getElementHelper();
				$element->addAttribute('style', $fontFamilyString );
			}

		}


		/*----------------------------------------------------------*/
		/* ELEMENT
		/*----------------------------------------------------------*/
		if( $query->exists('element') ) {
			$subQuery = $query->get('element');

			$options = array();

			$options[] = 'display';
			$options[] = 'opacity';
			$options[] = 'float';
			$options[] = 'overflow';
			$options[] = 'overflow-x';
			$options[] = 'overflow-y';
			$options[] = 'z-index';

			$this->_setInlineAttributes( $options, $subQuery );
		}

		/*----------------------------------------------------------*/
		/* POSITION
		/*----------------------------------------------------------*/
		if( $query->exists('position') ) {
			$subQuery = $query->get('position');

			$options = array();

			$options[] = 'position';

			$this->_setInlineAttributes( $options, $subQuery );

			$options = array();
			$options[] = 'top'; //px
			$options[] = 'right';//px
			$options[] = 'bottom';// px
			$options[] = 'left';//px
			$this->_setInlineAttributes( $options, $subQuery, true );
			

		}


		/*----------------------------------------------------------*/
		/* SIZE
		/*----------------------------------------------------------*/
		if( $query->exists('size') ) {
			$subQuery = $query->get('size');

			$options = array();

			$options[] = 'width';       // px
			$options[] = 'height';// px
			$options[] = 'min-width';// px
			$options[] = 'min-height';// px
			$options[] = 'max-width';// px
			$options[] = 'max-height';// px
			// %, px, em
			$this->_setInlineAttributes( $options, $subQuery, true );
		}

		/*----------------------------------------------------------*/
		/* CUSTOM STYLE
		/*----------------------------------------------------------*/
		if( $query->exists('custom-style') ) {
			$element->addAttribute('style', $query->get('custom-style') );
		}

		/*----------------------------------------------------------*/
		/* CUSTOM ATTRIBUTTES
		/*----------------------------------------------------------*/
		if( $query->exists('custom-attr') ) {
			$element->addStringAtEnd( $query->get('custom-attr') );
		}
	}




	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query ) {
				console.log('advancedToolsBlock');
			}
		</script data-type="ffscript">
		<?php
	}


	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->startTab('element.style', 'a-t', false, true);

		$wrapByModal = $this->getParam( ffThemeBuilderBlock_AdvancedTools::PARAM_WRAP_BY_MODAL, false );

		if( $wrapByModal ) {
			$s->startModal(  'Advanced Options', 'ff-advanced-options' );
		}

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Info');

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', 'These settings will be printed directly on the first wrapper of this element.');

			//    $s->addOption(ffOneOption::TYPE_TEXT,'advanced-tools', 'Advanced Tools', 'ssss');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Identification');
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'id', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'ID (attribute)');
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'cls', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'CSS class');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Typography');
				$s->startSection('typography');

					$s->addOptionNL( ffOneOption::TYPE_GFONT_SELECTOR, 'google-font-family', '', '')
						->addSelectValue('', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Google Font Family (you can add more fonts in Theme Options)');

					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'font-family', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'font-family (example: <code style="font-size: 10px;">\'Arial\', sans-serif</code>)');

					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'font-size', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'font-size');

					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'line-height', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'line-height');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'font-weight', '', '')
						->addSelectValue('', '')
						->addSelectValue('normal', 'normal')
						->addSelectValue('bold', 'bold')
						->addSelectNumberRange(100, 900, 100)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'font-weight');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'font-style', '', '')
						->addSelectValue('', '')
						->addSelectValue('normal', 'normal')
						->addSelectValue('italic', 'italic')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'font-style');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'text-transform', '', '')
						->addSelectValue('', '')
						->addSelectValue('none', 'none')
						->addSelectValue('uppercase', 'uppercase')
						->addSelectValue('lowercase', 'lowercase')
						->addSelectValue('capitalize', 'capitalize')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'text-transform');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'text-decoration', '', '')
						->addSelectValue('', '')
						->addSelectValue('none', 'none')
						->addSelectValue('underline', 'underline')
						->addSelectValue('overline', 'overline')
						->addSelectValue('line-through', 'line-through')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'text-decoration');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'text-align', '', '')
						->addSelectValue('', '')
						->addSelectValue('center', 'center')
						->addSelectValue('left', 'left')
						->addSelectValue('right', 'right')
						->addSelectValue('justify', 'justify')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'text-align');

				$s->endSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Element');

				$s->startSection('element');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'display', '', '')
						->addSelectValue('', '')
						->addSelectValue('none', 'none')
						->addSelectValue('block', 'block')
						->addSelectValue('inline-block', 'inline-block')
						->addSelectValue('inline', 'inline')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'display');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'opacity', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'opacity');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'float', '', '')
						->addSelectValue('', '')
						->addSelectValue('none', 'none')
						->addSelectValue('left', 'left')
						->addSelectValue('right', 'right')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'float');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'overflow', '', '')
						->addSelectValue('', '')
						->addSelectValue('hidden', 'hidden')
						->addSelectValue('scroll', 'scroll')
						->addSelectValue('visible', 'visible')
						->addSelectValue('auto', 'auto')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'overflow');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'overflow-x', '', '')
						->addSelectValue('', '')
						->addSelectValue('hidden', 'hidden')
						->addSelectValue('scroll', 'scroll')
						->addSelectValue('visible', 'visible')
						->addSelectValue('auto', 'auto')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'overflow-x');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'overflow-y', '', '')
						->addSelectValue('', '')
						->addSelectValue('hidden', 'hidden')
						->addSelectValue('scroll', 'scroll')
						->addSelectValue('visible', 'visible')
						->addSelectValue('auto', 'auto')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'overflow-y');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'z-index', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'z-index');

				$s->endSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Position');

				$s->startSection('position');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'position', '', '')
						->addSelectValue('', '')
						->addSelectValue('relative', 'relative')
						->addSelectValue('absolute', 'absolute')
						->addSelectValue('fixed', 'fixed')
						->addSelectValue('inline', 'inline')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'position');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'top', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'top');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'right', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'right');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'bottom', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'bottom');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'left', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'left');

				$s->endSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Size');

				$s->startSection('size');
	
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'width', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'width');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'height', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'height');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'min-width', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'min-width');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'min-height', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'min-height');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'max-width', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'max-width');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'max-height', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'max-height');

				$s->endSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Custom Style');

				$s->addOptionNL( ffOneOption::TYPE_TEXTAREA_STRICT, 'custom-style', '', '');
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', 'Example: <code>transition: 1s all ease; transition-duration: 1s; word-wrap: break-word;</code>');

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Custom HTML Attributes');

				$s->addOptionNL( ffOneOption::TYPE_TEXTAREA_STRICT, 'custom-attr', '', '');
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', 'Example: <code>data-my-color="green" data-my-name="Tay" onfocus="myFunction()"</code>');

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

		if( $wrapByModal ) {
			$s->endModal();
		}

		$s->endTab();

	}

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}