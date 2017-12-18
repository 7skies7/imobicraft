<?php

class ffThemeBuilderBlock_Colors extends ffThemeBuilderBlockBasic {
	const PARAM_TEXT_COLOR = 'text-color';
	/**********************************************************************************************************************/
	/* OBJECTS
	/**********************************************************************************************************************/

	/**********************************************************************************************************************/
	/* PRIVATE VARIABLES
	/**********************************************************************************************************************/
	private $_returnOnlyTextColor = false;
	/**********************************************************************************************************************/
	/* CONSTRUCT
	/**********************************************************************************************************************/
	protected function _init() {
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'colors');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'clrs');
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
	public function returnOnlyTextColor() {
		$this->_returnOnlyTextColor = true;

		return $this;
	}
	/**********************************************************************************************************************/
	/* PRIVATE FUNCTIONS
	/**********************************************************************************************************************/

	protected function _render( $query ) {
		/*----------------------------------------------------------*/
		/* TEXT COLOR
		/*----------------------------------------------------------*/
		/**
		 * Return only text color for stacking purposes (all text colors should be inherited)
		 */
		if( $this->_returnOnlyTextColor ) {


			$defaultValue = $this->_getDefaultColor();

			if( $this->_queryIsEmpty() ) {
				$textColor = $defaultValue;
			} else {
				$textColor = $query->getColorWithoutComparationDefault('text-color', $defaultValue);
			}
			$this->_returnOnlyTextColor = false;
			return $textColor;
		}



		$this->_renderTextColorDarkOrLight();

		if( $this->_queryIsEmpty() ) {
			return false;
		}

		$this->_renderTextColor( $query );
		$this->_renderTextHoverColor( $query );
		$this->_renderTextLinksHoverColor( $query );


		$this->_renderLinkColorFromInput( $query );
		$this->_renderLinkHoverColorFromInput( $query );

		$this->_renderFonts( $query );

		$this->_renderResponsiveTypography( $query );

	}

/**********************************************************************************************************************/
/* DARK OR LIGHT
/**********************************************************************************************************************/
	private function _renderTextColorDarkOrLight() {
		$textColor = $this->_getStatusHolder()->getCurrentTextColor();


		if( !empty( $textColor ) ) {
			$this->_getAssetsRenderer()->getElementHelper()->addAttribute('class', $textColor );
		}

	}

	private function _addUnitToInteger( $value, $unit = 'px' ) {
		if( is_numeric( $value ) ) {
			return $value . $unit;
		} else {
			return $value;
		}
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderFonts( $query ) {

		$googleFontFamily = $query->getWithoutComparationDefault('google-font-family', '');
		$userFontFamily = $query->getWithoutComparationDefault('font-family', '');
//		$fontSize = $query->getWithoutComparationDefault('font-size', '');
//		$lineHeight = $query->getWithoutComparationDefault('line-height', '');
//		$letterSpacing = $query->getWithoutComparationDefault('letter-spacing', '');
//		$fontWeight = $query->getWithoutComparationDefault('font-weight', '');
		$fontStyle = $query->getWithoutComparationDefault('font-style', '');
		$textTransform = $query->getWithoutComparationDefault('text-transform', '');
		$textDecoration = $query->getWithoutComparationDefault('text-decoration', '');
//		$textAlign = $query->getWithoutComparationDefault('text-align', '');


		$fontsCss = array();

		/*----------------------------------------------------------*/
		/* FONT FAMILY
		/*----------------------------------------------------------*/
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
			$fontsCss[] = 'font-family: ' . $fontFamilyString .' !important;';
		}



		if( !empty( $fontStyle ) ) {
			$fontsCss[] = 'font-style: ' . $fontStyle .' !important;';
		}

		if( !empty( $textTransform ) ) {
			$fontsCss[] = 'text-transform: ' . $textTransform . ' !important;';
		}

		if( !empty( $textDecoration ) ) {
			$fontsCss[] = 'text-decoration: ' . $textDecoration .' !important;';
		}


		$fontsString = implode( PHP_EOL, $fontsCss );

		if( !empty( $fontsString ) ) {
			$assetsRenderer = $this->_getAssetsRenderer();

			$assetsRenderer->createCssRule()
				->addParamsString( $fontsString );

			$assetsRenderer->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->createNewSelectorBranch(' ', false)
				->createNewSelectorBranch(':before', false)
				->createNewSelectorBranch(':after', false)
				->createNewSelectorBranch(':hover', false)
				->createNewSelectorBranch(':focus', false)
				->createNewSelectorBranch(' *', false)
				->createNewSelectorBranch(' *:before', false)
				->createNewSelectorBranch(' *:after', false)
				->createNewSelectorBranch(' *:hover', false)
				->createNewSelectorBranch(' *:focus', false)
				->addParamsString( $fontsString );
		}

	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderResponsiveTypography( $query ) {

		$breakpoints =  $this->_getBreakpoints();

		foreach( $breakpoints as $name => $breakpointValue ) {
			$breakpointName = str_replace('-', '', $breakpointValue );

			$textAlign = $query->getWithoutComparationDefault('text-align'.$breakpointValue, '');
			$fontSize = $query->getWithoutComparationDefault('font-size'.$breakpointValue, '');
			$lineHeight = $query->getWithoutComparationDefault('line-height'.$breakpointValue, '');
			$letterSpacing = $query->getWithoutComparationDefault('letter-spacing'.$breakpointValue, '');
			$fontWeight = $query->getWithoutComparationDefault('font-weight'.$breakpointValue, '');

			$fontsCss = array();

			if( !empty( $fontSize ) ) {
				$fontsCss[] = 'font-size: ' . $this->_addUnitToInteger( $fontSize ) .' !important;';
			}

			if( !empty( $lineHeight ) ) {
				$fontsCss[] = 'line-height: ' . $lineHeight .' !important;';
			}

			if( !empty( $letterSpacing ) ) {
				$fontsCss[] = 'letter-spacing:' . $this->_addUnitToInteger( $letterSpacing ) . ' !important;';
			}

			if( !empty( $fontWeight ) ) {
				$fontsCss[] = 'font-weight: ' . $fontWeight .' !important;';
			}

			if( !empty( $textAlign ) ) {
				$fontsCss[] = 'text-align: ' . $textAlign .' !important;';
			}


			$fontsString = implode( PHP_EOL, $fontsCss );

			if( !empty( $fontsString ) ) {
				$assetsRenderer = $this->_getAssetsRenderer();

				$cssRuleGeneral = $assetsRenderer->createCssRule();

				if( !empty($breakpointName) ) {
					$cssRuleGeneral->addBreakpointMin( $breakpointName );
				}
				$cssRuleGeneral->addParamsString( $fontsString );

//				$assetsRenderer->createCssRule()
//					->addParamsString( $fontsString );

				$cssRuleAllChildren = $assetsRenderer->createCssRule();

				if( !empty($breakpointName) ) {
					$cssRuleAllChildren->addBreakpointMin( $breakpointName );
				}


				$cssRuleAllChildren->setAddWhiteSpaceBetweenSelectors(false)
					->createNewSelectorBranch('', false)
					->createNewSelectorBranch(':before', false)
					->createNewSelectorBranch(':after', false)
					->createNewSelectorBranch(':hover', false)
					->createNewSelectorBranch(':focus', false)
					->createNewSelectorBranch(' *', false)
					->createNewSelectorBranch(' *:before', false)
					->createNewSelectorBranch(' *:after', false)
					->createNewSelectorBranch(' *:hover', false)
					->createNewSelectorBranch(' *:focus', false)
					->addParamsString( $fontsString );
			}
		}

	}

	private function _getDefaultColor() {

		$defaultValue = '';
		if( $this->getParam( ffThemeBuilderBlock_Colors::PARAM_TEXT_COLOR ) == 'dark' ) {
			$defaultValue = 'fg-text-dark';
		}
		if( $this->getParam( ffThemeBuilderBlock_Colors::PARAM_TEXT_COLOR ) == 'light' ) {
			$defaultValue = 'fg-text-light';
		}

		return $defaultValue;
	}


/**********************************************************************************************************************/
/* TEXT COLOR
/**********************************************************************************************************************/
	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderTextColor( $query ) {

		$customColor = $query->getColorWithoutComparationDefault('text-custom-color', '');

		if( $customColor ) {

			$assetsRenderer = $this->_getAssetsRenderer();
			$css = 'color: ' .$customColor . ' !important;';


			$assetsRenderer->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->createNewSelectorBranch('', false)
				->createNewSelectorBranch(':before', false)
				->createNewSelectorBranch(':after', false)
				->createNewSelectorBranch(' *', false)
				->createNewSelectorBranch(' *:before', false)
				->createNewSelectorBranch(' *:after', false)
				->addParamsString( $css );
		}
	}

/**********************************************************************************************************************/
/* TEXT HOVER COLOR
/**********************************************************************************************************************/
	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderTextHoverColor( $query ) {
		$customColor = $query->getColorWithoutComparationDefault('text-hover-custom-color', '');

		if( $customColor ) {

			$assetsRenderer = $this->_getAssetsRenderer();
			$css = 'color: ' .$customColor . ' !important;';

			//#123:hover,
			//#123:hover:before,
			//#123:hover:after,
			//#123:hover:before:hover,
			//#123:hover:after:hover
			//#123:hover *,
			//#123:hover *:before,
			//#123:hover *:after,
			//#123:hover *:before:hover,
			//#123:hover *:after:hover
			$assetsRenderer->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(':hover', false)
				->createNewSelectorBranch(':hover:before', false)
				->createNewSelectorBranch(':hover:after', false)
				->createNewSelectorBranch(':hover *', false)
				->createNewSelectorBranch(':hover *:before', false)
				->createNewSelectorBranch(':hover *:after', false)
				->addParamsString( $css );

			$assetsRenderer->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(':hover', false)
				->createNewSelectorBranch(':hover:before:hover', false)
				->createNewSelectorBranch(':hover:after:hover', false)
				->createNewSelectorBranch(':hover *:before:hover', false)
				->createNewSelectorBranch(':hover *:after:hover', false)
				->addParamsString( $css );

		}
	}

/**********************************************************************************************************************/
/* TEXT LINKS HOVER COLOR
/**********************************************************************************************************************/

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderTextLinksHoverColor( $query ) {
		$customColor = $query->getColorWithoutComparationDefault('text-links-hover-custom-color', '');

		if( $customColor ) {

			$assetsRenderer = $this->_getAssetsRenderer();
			$css = 'color: ' .$customColor . ' !important;';

//#123:hover a,
//#123:hover a:before,
//#123:hover a:after,
//#123:hover a:before:hover,
//#123:hover a:after:hover
//#123:hover a *,
//#123:hover a *:before,
//#123:hover a *:after,
//#123:hover a *:before:hover,
//#123:hover a *:after:hover
			$assetsRenderer->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(':hover a', false)
//				->createNewSelectorBranch(':hover a:before', false)
//				->createNewSelectorBranch(':hover a:after', false)
//				->createNewSelectorBranch(':hover a:before:hover', false)
//				->createNewSelectorBranch(':hover a:after:hover', false)
//				->createNewSelectorBranch(':hover a *', false)
//				->createNewSelectorBranch(':hover a *:before', false)
//				->createNewSelectorBranch(':hover a *:after', false)
//				->createNewSelectorBranch(':hover a *:before:hover', false)
//				->createNewSelectorBranch(':hover a *:after:hover', false)

				->addParamsString( $css );


		}
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderLinkColorFromInput( $query ) {

		$linkCustomColor = $query->getColorWithoutComparationDefault('link-custom-color', '');

		if($linkCustomColor){

			$assetsRenderer = $this->_getAssetsRenderer();
			$css = 'color: ' .$linkCustomColor . ' !important;';

//			#123 a,
//			#123 a:before,
//			#123 a:after
//			#123 a *,
//			#123 a *:before,
//			#123 a *:after

			$assetsRenderer->createCssRule()
				->addSelector('a', false)
				->createNewSelectorBranch('a:before', false)
				->createNewSelectorBranch('a:after', false)
				->createNewSelectorBranch('a *', false)
				->createNewSelectorBranch('a *:before', false)
				->createNewSelectorBranch('a *:after', false)
				->addParamsString( $css );

		}
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderLinkHoverColorFromInput( $query ) {

		$linkHoverCustomColor = $query->getColorWithoutComparationDefault('link-hover-custom-color', '');

		if($linkHoverCustomColor){

			$css = 'color: ' .$linkHoverCustomColor . ' !important;';

			#123 a:hover,
			#123 a:hover:before,
			#123 a:hover:after,
			#123 a:hover:before:hover,
			#123 a:hover:after:hover
			#123 a:hover *,
			#123 a:hover *:before,
			#123 a:hover *:after,
			#123 a:hover *:before:hover,
			#123 a:hover *:after:hover

	//		#123 a:hover,
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('a:hover',false)
				->createNewSelectorBranch('a:hover:before', false)
				->createNewSelectorBranch('a:hover:after', false)
//				->createNewSelectorBranch('a:hover:before:hover', false)
//				->createNewSelectorBranch('a:hover:after:hover', false)
				->createNewSelectorBranch('a:hover *', false)
				->createNewSelectorBranch('a:hover *:before', false)
				->createNewSelectorBranch('a:hover *:after', false)
//				->createNewSelectorBranch('a:hover *:before:hover', false)
//				->createNewSelectorBranch('a:hover *:after:hover', false)
				->addParamsString( $css );
//
//	//		#123 a:hover:before,
//			$this->_getAssetsRenderer()->createCssRule()
//				->addSelector('a:hover:before',false)
//				->addParamsString( $css );
//
//	//		#123 a:hover:after,
//			$this->_getAssetsRenderer()->createCssRule()
//				->addSelector('a:hover:after',false)
//				->addParamsString( $css );
//
//	//		#123 a:hover:before:hover,
//			$this->_getAssetsRenderer()->createCssRule()
//				->addSelector('a:hover:before:hover',false)
//				->addParamsString( $css );
//
//	//		#123 a:hover:after:hover
//			$this->_getAssetsRenderer()->createCssRule()
//				->addSelector('a:hover:after:hover',false)
//				->addParamsString( $css );
//
//	//		#123 a:hover *,
//			$this->_getAssetsRenderer()->createCssRule()
//				->addSelector('a:hover *',false)
//				->addParamsString( $css );
//
//	//		#123 a:hover *:before,
//			$this->_getAssetsRenderer()->createCssRule()
//				->addSelector('a:hover *:before',false)
//				->addParamsString( $css );
//
//	//		#123 a:hover *:after,
//			$this->_getAssetsRenderer()->createCssRule()
//				->addSelector('a:hover *:after',false)
//				->addParamsString( $css );
//
//	//		#123 a:hover *:before:hover,
//			$this->_getAssetsRenderer()->createCssRule()
//				->addSelector('a:hover *:before:hover',false)
//				->addParamsString( $css );
//
//	//		#123 a:hover *:after:hover
//			$this->_getAssetsRenderer()->createCssRule()
//				->addSelector('a:hover *:after:hover',false)
//				->addParamsString( $css );

		}
	}




	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {
	
		$s->startTab('Typography', 'clrs', false, true);

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Info');

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', 'Typography settings will be applied on this element and recursively to all inner elements unless overwritten on one of the inner elements via their own Typography tab. If you want your styles to be less invasive, please use the "element.style" or "Custom Code" tabs instead.');

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Text Color Palette');

				$defaultValue = $this->_getDefaultColor();

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'text-color', '',$defaultValue)
					->addSelectValue('Inherited', '')
					->addSelectValue('Light Text', 'fg-text-light')
					->addSelectValue('Dark Text', 'fg-text-dark')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Text Colors');

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-custom-color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Element Text Color') )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-hover-custom-color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Element Hover Text Color') )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-links-hover-custom-color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Element Hover Inner Links Color') )
				;

				$s->addElement( ffOneElement::TYPE_NEW_LINE );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-custom-color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Element Inner Links Color') )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-hover-custom-color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Element Inner Links Hover Color') )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$breakpoints = $this->_getBreakpoints();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Text Align');
				foreach( $breakpoints as $name => $prefix ) {

					$id = 'text-align' . $prefix;

					$value = '';

					$inheritName = '';
					// if( $prefix != '' ) {
						$inheritName  = 'inherit';
					// }

					$option = $s->addOptionNL( ffOneOption::TYPE_SELECT, $id, $name, $value)
						->addSelectValue($inheritName, '')
						->addSelectValue('center', 'center')
						->addSelectValue('left', 'left')
						->addSelectValue('right', 'right')
						->addSelectValue('justify', 'justify')
					;

//					if( $prefix != '' ) {
//						$option->addSelectValue('inherit', 'inherit');
//					}

				}


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Font Size');
				foreach( $breakpoints as $name => $prefix ) {

					$id = 'font-size' . $prefix;

					$value = '';

					$option = $s->addOptionNL( ffOneOption::TYPE_TEXT, $id, $name, $value)
					;

					// if( $prefix != '' ) {
						$option->addParam('placeholder', 'Inherit');
					// }

				}


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Line Height');
				$description = 'By default, line height is unitless. So if you insert 1.2, then the size is <code>( your_font_size*1.2)</code>. So if you need pixels, don\'t forget to add "px"';
				foreach( $breakpoints as $name => $prefix ) {

					$id = 'line-height' . $prefix;

					$value = '';

					$option = $s->addOptionNL( ffOneOption::TYPE_TEXT, $id, $name, $value)
					;

					// if( $prefix != '' ) {
						$option->addParam('placeholder', 'Inherit');
					// }

				}
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Letter Spacing');
				foreach( $breakpoints as $name => $prefix ) {

					$id = 'letter-spacing' . $prefix;

					$value = '';

					$option = $s->addOptionNL( ffOneOption::TYPE_TEXT, $id, $name, $value)
					;

					// if( $prefix != '' ) {
						$option->addParam('placeholder', 'Inherit');
					// }

				}
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Font Weight');
				foreach( $breakpoints as $name => $prefix ) {

					$id = 'font-weight' . $prefix;

					$value = '';

					$inheritName = '';
					// if( $prefix != '' ) {
						$inheritName  = 'inherit';
					// }


					$option = $s->addOptionNL( ffOneOption::TYPE_SELECT, $id, $name, $value)
						->addSelectValue($inheritName, '')
						->addSelectValue('normal', 'normal')
						->addSelectValue('bold', 'bold')
						->addSelectNumberRange(100, 900, 100)
					;
//
//					if( $prefix != '' ) {
//						$option->addSelectValue('inherit', 'inherit');
//					}

				}


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Other Typography');

				$description = 'Font families will be printed in this order: <code>Google Font, User Font, Arial, sans-serif</code>';

				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', $description);
				$s->addElement( ffOneElement::TYPE_NEW_LINE );

				$s->addOptionNL( ffOneOption::TYPE_GFONT_SELECTOR, 'google-font-family', '', '')
					->addSelectValue('', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Google Font Family (you can add more fonts in Theme Options)');

				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'font-family', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Font Family (example: <code style="font-size: 10px;">\'Arial\', sans-serif</code>)');

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'font-style', '', '')
					->addSelectValue('', '')
					->addSelectValue('normal', 'normal')
					->addSelectValue('italic', 'italic')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Font Style');

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'text-transform', '', '')
					->addSelectValue('', '')
					->addSelectValue('none', 'none')
					->addSelectValue('uppercase', 'uppercase')
					->addSelectValue('lowercase', 'lowercase')
					->addSelectValue('capitalize', 'capitalize')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Text Transform');

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'text-decoration', '', '')
					->addSelectValue('', '')
					->addSelectValue('none', 'none')
					->addSelectValue('underline', 'underline')
					->addSelectValue('overline', 'overline')
					->addSelectValue('line-through', 'line-through')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Text Decoration');


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);




		$s->addElement( ffOneElement::TYPE_TABLE_END );
		$s->endTab();

	}
	/**********************************************************************************************************************/
	/* PRIVATE GETTERS & SETTERS
	/**********************************************************************************************************************/

	private function _getBreakpoints() {
		$bp = array();
		$bp['Phone (XS)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'] = '';
		$bp['Tablet (SM)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'] = '-sm';
		$bp['Laptop (MD)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'] = '-md';
		$bp['Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;'] = '-lg';

		return $bp;
	}

}