<?php

class ffThemeBuilderBlock_CustomCodes extends ffThemeBuilderBlockBasic {
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
        $this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'custom-codes');
        $this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'cc');
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
	protected function _mergeTwoStylesData($globalStyles, $instanceStyles) {
		$newStyle = [];

		$counter = 0;
		if( isset( $globalStyles['grp'] ) ) {
			foreach( $globalStyles['grp'] as $name => $value ) {
				$nameExploded = explode('-|-', $name);
				$newName = $counter . '-|-' . $nameExploded[1];

				$newStyle[ $newName ] = $value;
				$counter++;
			}
		}

		if( isset( $instanceStyles['grp'] ) ) {
			foreach( $instanceStyles['grp'] as $name => $value ) {
				$nameExploded = explode('-|-', $name);
				$newName = $counter . '-|-' . $nameExploded[1];

				$newStyle[ $newName ] = $value;
				$counter++;
			}
		}

		if( !empty( $newStyle ) ) {
			return array('grp'=> $newStyle);
		} else {
			return array();
		}

//		var_dump( $newStyle );
//
//		return $newStyle;
//



//		$toReturn = array_replace_recursive( $lessImportantData->getData(), $importantData->getData() );
//		ffStopWatch::addVariableDump( $toReturn );

//		return $toReturn;
	}

    protected function _render( $query ) {

	    if( $this->_queryIsEmpty() ) {
		    return null;
	    }

	    if( $query->queryExists('grp') ) {

		    /**
		     * @var $oneGroup ffOptionsQuery
		     */
	        foreach( $query->get('grp') as $oneGroup ) {
		        $type = $oneGroup->getVariationType();

		        /*----------------------------------------------------------*/
		        /* CSS RULE
		        /*----------------------------------------------------------*/
		        if( $type == 'css' ) {
			        $styles = $oneGroup->getWithoutComparationDefault( 'styles', 'border: 10px solid red !important;');

//			        $selector = $oneGroup->getWithoutComparationDefault('slct', '');
			        $cssRule = $this->_getAssetsRenderer()->createCssRule( false );

			        $selectors = $this->_getAssetsRenderer()->getSelectors();

			        $selectorString = $oneGroup->getWithoutComparationDefault('slct', '');

					$cleanSelectors = [];
					$hasBeenElementInside = false;
					foreach( array_reverse($selectors) as $oneSelector ) {
						if( !$hasBeenElementInside ) {
							array_unshift( $cleanSelectors, ($oneSelector) );
						}
//						ffStopWatch::addVariableDump( $oneSelector );
						if( strpos($oneSelector, 'ffb-id') !== false ) {
							$hasBeenElementInside = true;
						}
					}

					$selectors = $cleanSelectors;

//					ffStopWatch::addVariableDump( $selectors );

					if( $oneGroup->getWithoutComparationDefault('slct-switch', '') == '' ) {
						foreach( $selectors as $key => $value ) {
							$selectorString = str_replace( '%s' . ($key+1), '.'.$value, $selectorString );
						}
					} else {
						$selectorStringAbsolute = implode(' .', $selectors );

						$selectorString = str_replace( '%s1', '.'.$selectorStringAbsolute, $selectorString);
					}


				
			        /**
			         * Media Query Min
			         */
			        $mediaQueryMin = $oneGroup->getWithoutComparationDefault('min', '');

			        if( !empty( $mediaQueryMin ) ) {
				        switch( $mediaQueryMin ) {
					        case 'xs':
									$cssRule->addBreakpointXsMin();
						        break;

					        case 'sm':
									$cssRule->addBreakpointSmMin();
						        break;

					        case 'md':
									$cssRule->addBreakpointMdMin();
						        break;

					        case 'lg':
									$cssRule->addBreakpointLGMin();
						        break;
				        }
			        }

			        /**
			         * Media Query Max
			         */
			        $mediaQueryMax = $oneGroup->getWithoutComparationDefault('max', '');

			        if( !empty( $mediaQueryMax ) ) {
				        switch( $mediaQueryMax ) {
					        case 'xs':
						        $cssRule->addBreakpointXsMax();
						        break;

					        case 'sm':
						        $cssRule->addBreakpointSmMax();
						        break;

					        case 'md':
						        $cssRule->addBreakpointMdMax();
						        break;

//					        case 'lg':
//						        $cssRule->addBreakpointLGMax();
//						        break;
				        }
			        }

			        /**
			         * States
			         */
			        $stateArray = Array();

			        if( $oneGroup->getWithoutComparationDefault('state1', null) != null ) {
				        $stateArray[] = $oneGroup->getWithoutComparationDefault('state1', null);
			        }

			        if( $oneGroup->getWithoutComparationDefault('state2', null) != null ) {
				        $stateArray[] = $oneGroup->getWithoutComparationDefault('state2', null);
			        }

					if( !empty( $stateArray ) ) {
						$state = implode( ':', $stateArray );
						$cssRule->setState( $state );
					}


			        /**
			         * Extra selector, like #someIdBro
			         */
			        if( !empty( $selectorString ) ){
//				        if( !$oneGroup->getWithoutComparationDefault('space', 1) ) {
//					        $cssRule->setAddWhiteSpaceBetweenSelectors(false);
//				        }

				        $cssRule->addSelector( $selectorString, false );
			        }

			        /**
			         * the style sitself
			         */
			        if( !empty( $styles) ) {
				        $cssRule->addParamsString( $styles );
			        }
		        }
		        /*----------------------------------------------------------*/
		        /* JAVASCRIPT CODE
		        /*----------------------------------------------------------*/
		        else if ($type == 'js' ) {
			        $jsCode = $cssRule = $this->_getAssetsRenderer()->createJavascriptCode();

			        $wrapByAnonymousFn = $oneGroup->getWithoutComparationDefault('wrap-by-anonymous-fn', 1);
			        $wrapByDocumentReady = $oneGroup->getWithoutComparationDefault('wrap-by-document-ready', 1);
			        $code = $oneGroup->getWithoutComparationDefault('javascript', '$(!selector!).css(\'border\',\'10px solid red\');');

			        $jsCode->setWrapByAnonymousFunction( $wrapByAnonymousFn );
			        $jsCode->setWrapByDocumentReady( $wrapByDocumentReady );
			        $jsCode->setCode( $code );

		        }
	        }
	    }
    }

    protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {
	    $s->startTab('Custom Code', 'cc', false, true);
        $s->addElement( ffOneElement::TYPE_TABLE_START );

            $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Info');

                $s->addElement(ffOneElement::TYPE_DESCRIPTION,'', 'You can add your custom CSS and JavaScript code here. Every element has it\'s own unique CSS class that will help you target it. Custom CSS and JavaScript code will be printed at the end of the page.');

            $s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

            $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Custom Code');


	            $s->startSection('grp', ffOneSection::TYPE_REPEATABLE_VARIABLE )
		            ->addParam('can-be-empty', true)
		            ->addParam('work-as-accordion', true)
		            ->addParam('all-items-opened', true)
	            ;

					/*----------------------------------------------------------*/
					/* CSS
					/*----------------------------------------------------------*/
	                $s->startSection('css', ffOneSection::TYPE_REPEATABLE_VARIATION)
		                ->addParam('hide-default', true)
		                ->addParam('section-name', 'CSS');

	                    $s->addElement(ffOneElement::TYPE_HTML,'', '<div class="ffb-custom-css-code-wrapper">');

		                    $s->addOptionNL( ffOneOption::TYPE_SELECT, 'min', '', '')
			                    ->addSelectValue('', '')
			                    ->addSelectValue('Min Phone (XS)', 'xs')
			                    ->addSelectValue('Min Tablet (SM)', 'sm')
			                    ->addSelectValue('Min Laptop (MD)', 'md')
			                    ->addSelectValue('Min Desktop (LG)', 'lg')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Minimal Viewport') );
		                    ;

						    $s->addOptionNL( ffOneOption::TYPE_SELECT, 'max', '', '')
							    ->addSelectValue('', '')
							    ->addSelectValue('Max Phone (XS)', 'xs')
							    ->addSelectValue('Max Tablet (SM)', 'sm')
							    ->addSelectValue('Max Laptop (MD)', 'md')
	//						    ->addSelectValue('Desktop (LG)', 'lg')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Maximal Viewport') );
						    ;

							$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ff-selector-switcher-holder">');
								$s->addOptionNL( ffOneOption::TYPE_SELECT, 'slct-switch', '', '')
									->addSelectValue('Relative', 'rel')
									->addSelectValue('Absolute', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Selector Mode') )
								;
							$s->addElement( ffOneElement::TYPE_HTML, '', '</div>');

	                        $s->addOptionNL( ffOneOption::TYPE_TEXT, 'slct', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Custom Selector') )
							;

							$s->addElement(ffOneElement::TYPE_NEW_LINE);




							$s->addElement( ffOneElement::TYPE_HTML, '', __('<div class="ffb-options-textarea-code-wrapper ffb-options-textarea-code-cc-css">') );

			                    	$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ff-media-query-before ffb-options-textarea-code-prefix">mq</div>');

			                    		$s->addElement( ffOneElement::TYPE_HTML, '', '<span class="ff-selector ffb-options-textarea-code-prefix"></span>');

									  	  $s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT, 'styles', '', 'border: 10px solid red !important;')
										      ->addParam('no-wrapping', true)
												->addParam( ffOneOption::PARAM_CODE_EDITOR, 'css')
									  		;

										$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ff-selector-after ffb-options-textarea-code-prefix">}</div>');

									$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ff-media-query-after ffb-options-textarea-code-prefix">mq</div>');


							$s->addElement( ffOneElement::TYPE_HTML, '', __('</div>') );



	                    $s->addElement(ffOneElement::TYPE_HTML,'', '</div>');

	                $s->endSection();

	                /*----------------------------------------------------------*/
	                /* JS
	                /*----------------------------------------------------------*/
				    $s->startSection('js', ffOneSection::TYPE_REPEATABLE_VARIATION)
					    ->addParam('hide-default', true)
					    ->addParam('section-name', 'JavaScript');

	                    $s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'wrap-by-anonymous-fn', 'Use jQuery', 1);

	                    $s->startHidingBox('wrap-by-anonymous-fn', 'checked');
					    	$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'wrap-by-document-ready', 'Wrap with <code>$(document).ready()</code>', 1);
					    $s->endHidingBox();


					    // $text .= '<strong>any string "!selector!" (not with the quotes) will be replaced with <span class="ff-insert-unique-css-class"></span> when printing code</strong>';
					    // $text .= '<br>So you can use $(\'!selector!\') in your codes';

					    $s->addElement(ffOneElement::TYPE_NEW_LINE);

					    $s->addElement( ffOneElement::TYPE_HTML, '', __('<div class="ffb-options-textarea-code-wrapper ffb-options-textarea-code-cc-js">') );

					    	$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-prefix ffb-options-textarea-code-cc-js-js-start"></div>');

					    		$s->startHidingBox('wrap-by-anonymous-fn', 'checked');
					    		$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-prefix ffb-options-textarea-code-cc-js-jquery-start"></div>');
					    		$s->endHidingBox();

					    			$s->startHidingBox('wrap-by-document-ready', 'checked');
					    			$s->startHidingBox('wrap-by-anonymous-fn', 'checked');
					    			$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-prefix ffb-options-textarea-code-cc-js-docready-start"></div>');
					    			$s->endHidingBox();
					    			$s->endHidingBox();

					    				$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT, 'javascript', '', '$(\'!selector!\').css(\'background\',\'red\');')
										    ->addParam('no-wrapping', true)
											->addParam( ffOneOption::PARAM_CODE_EDITOR, 'css')
										;

					    			$s->startHidingBox('wrap-by-document-ready', 'checked');
					    			$s->startHidingBox('wrap-by-anonymous-fn', 'checked');
					    			$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-prefix ffb-options-textarea-code-cc-js-docready-end"></div>');
					    			$s->endHidingBox();
					    			$s->endHidingBox();

					    		$s->startHidingBox('wrap-by-anonymous-fn', 'checked');
					    		$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-prefix ffb-options-textarea-code-cc-js-jquery-end"></div>');
					    		$s->endHidingBox();

					    	$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-prefix ffb-options-textarea-code-cc-js-js-end"></div>');

						$s->addElement( ffOneElement::TYPE_HTML, '', __('</div>') );

            			$s->addElement(ffOneElement::TYPE_NEW_LINE);

            			$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', '<strong>Important:</strong> In order to reference this element in your JavaScript code, please use this string: <br><code style="margin: 5px 0;" class="ff-unique-css-class-box-styling">!selector!</code><br>It will be replaced with the unique CSS class automatically during page rendering. So for example a jQuery object of this element can be written as: <br><code style="margin: 5px 0;" class="ff-unique-css-class-box-styling">$(\'!selector!\')</code>');
            			// $s->addElement(ffOneElement::TYPE_HTML,'', '<div class="ff-unique-css-class-box">$(\'!selector!\')</div>');

				    $s->endSection();


	            $s->endSection();

            $s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

            $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Unique CSS Class');
            	$s->addElement(ffOneElement::TYPE_HTML,'', '<code class="ff-insert-unique-css-class ff-unique-css-class-box ff-unique-css-class-box-styling">UNIQUE CSS CLASS</code>');
            	$s->addElement(ffOneElement::TYPE_NEW_LINE);
            	$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', 'This element has a unique CSS class that is displayed above. <strong>Before you copy it, read the warning below.</strong>');
            $s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

            $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Warning!');
            	$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', '<strong>If this element is duplicated or re-ordered it might receive a new unique CSS class. That\'s why we don\'t recommend "hard-coding" it anywhere outside of this admin area. Rather use the Custom Code tools located above - they will refresh the class automatically for your peace of mind. This way your code stays perfectly portable.</strong>');
            $s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

        $s->addElement( ffOneElement::TYPE_TABLE_END );
	    $s->endTab();
    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}