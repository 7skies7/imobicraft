<?php

class ffThemeBuilderBlock_BoxModel extends ffThemeBuilderBlockBasic {
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
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'box-model');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'b-m');
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


	private function _getInjectedData() {
//		{'b-m':{'pd-xs':{'t':158}
		$d = [];
		$d['b-m'] = [];
		$d['b-m']['pd-xs'] = [];
		$d['b-m']['pd-xs']['t'] = 158;
		$d['b-m']['pd-xs']['b'] = 158;
		$d['b-m']['pd-xs']['r'] = 158;
		$d['b-m']['pd-xs']['l'] = 158;

		return $d['b-m'];
	}

	/**
	 * @param ffOptionsQuery $query
	 */
	private function _getQueryPathForThisBlock( $query ) {
		$path = $query->getPathWithoutRepeatables(true);
		$wrappingId = $this->_getInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID );

		// "b-m" == "b-m"
		if( end($path) == $wrappingId ) {
//			$path[] = $wrappingId;
			array_pop( $path );
		}

		return implode(' ', $path);
	}

	protected function _render( $query ) {

		if( $this->_queryIsEmpty() ) {
			return false;
		}

		/*----------------------------------------------------------*/
		/* BACKGROUNDS
		/*----------------------------------------------------------*/
		$this->_getBlock( ffThemeBuilderBlock::BACKGROUNDS )->render( $query );

		/*----------------------------------------------------------*/
		/* PADDING AND MARGIN
		/*----------------------------------------------------------*/
		$this->_renderMarginAndPadding( $query );

		/*----------------------------------------------------------*/
		/* BORDERS
		/*----------------------------------------------------------*/
		$this->_renderBorders( $query );

		/*----------------------------------------------------------*/
		/* BOX SHADOWS
		/*----------------------------------------------------------*/
		$this->_renderBoxShadows( $query );

		/*----------------------------------------------------------*/
		/* ROUNDED CORNERS
		/*----------------------------------------------------------*/
		$this->_renderRoundedCorners( $query );

		/*----------------------------------------------------------*/
		/* RENDER WIDTH AND HEIGHT
		/*----------------------------------------------------------*/
		$this->_renderWidthAndHeight( $query );

		/*----------------------------------------------------------*/
		/* MIN HEIGHT
		/*----------------------------------------------------------*/
		$this->_renderMinHeight( $query );

		/*----------------------------------------------------------*/
		/* HIDE ON
		/*----------------------------------------------------------*/
		$this->_renderHideOn( $query );

		/*----------------------------------------------------------*/
		/* ANIMATION
		/*----------------------------------------------------------*/
		$this->_renderAnimation( $query );
	}

/**********************************************************************************************************************/
/* MARGIN AND PADDING
/**********************************************************************************************************************/
	protected function _getMarginOrPaddingCssStringForBp( $query, $route, $type ) {
		$positions = $this->_getPositions();
		$css = '';

		if( $query->queryExists($route ) ) {
			$mgOrPd = $query->get( $route );

			foreach( $positions as $onePos => $posName ) {
				if( $mgOrPd->queryExists( $onePos ) ) {
					$pos = ( $mgOrPd->get( $onePos ) );

					$pos = $this->_addUnitToNumber( $pos );

					$css .= $type. '-' . $posName . ': ' . $pos . ';' . PHP_EOL;
				}
			}
		}

		return $css;
	}


	protected function _renderMarginAndPadding( ffOptionsQuery $query ) {
		/*----------------------------------------------------------*/
		/* MARGIN AND PADDING
		/*----------------------------------------------------------*/
		$breakpoints = $this->_getBreakpoints();

		foreach( $breakpoints as $bp => $title ) {
			$margin = 'mg-' . $bp;
			$padding = 'pd-' . $bp;

			$css = '';

			$css .= $this->_getMarginOrPaddingCssStringForBp( $query, $margin, 'margin');
			$css .= $this->_getMarginOrPaddingCssStringForBp( $query, $padding, 'padding');

			// RENDER
			if( !empty( $css ) ) {

				$this->_getAssetsRenderer()
					->createCssRule()
					->addBreakpointMin( $bp )
					->addParamsString( $css );
			}

		}


	}
/**********************************************************************************************************************/
/* BORDERS
/**********************************************************************************************************************/
	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderBorders( $query ) {
		if( $query->queryExists('borders') ) {

			$css = '';

			foreach( $query->get('borders') as $oneBorder ) {
				$type = $oneBorder->getWithoutComparationDefault('type', 'border');
				$width = $oneBorder->getWithoutComparationDefault('width', '1');
				$style = $oneBorder->getWithoutComparationDefault('style', 'solid');
				$color = $oneBorder->getColorWithoutComparationDefault('color', 'rgba(128,128,128,0.4)');

				$css .= $type . ': ' . $width . 'px ' . $style . ' ' . $color .' !important;' . PHP_EOL;
			}

			$this->_getAssetsRenderer()->createCssRule()->addParamsString( $css );
		}

	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderBoxShadows( $query ) {

		if( $query->queryExists('box-shadows') ) {
			$css = '';
			foreach( $query->get('box-shadows') as $oneShadow ) {
				$set = $oneShadow->getWithoutComparationDefault('set', 'outer');
				$offsetX = $oneShadow->getWithoutComparationDefault('offset-x', '0');
				$offsetY = $oneShadow->getWithoutComparationDefault('offset-y', '3');
				$blurRadius = $oneShadow->getWithoutComparationDefault('blur-radius', '5');
				$spreadRadius = $oneShadow->getWithoutComparationDefault('spread-radius', '0');
				$color = $oneShadow->getColorWithoutComparationDefault('color', 'rgba(0,0,0,0.18)');

				if ( !$offsetX ){ $offsetX = '0'; }
				if ( !$offsetY ){ $offsetY = '0'; }
				if ( !$blurRadius ){ $blurRadius = '0'; }
				if ( !$spreadRadius ){ $spreadRadius = '0'; }
				if ( !$color ){ $color = 'rgba(0,0,0,0)'; }

				$css .= 'box-shadow: ';

				if( $set == 'inset' ) {
					$css .= 'inset ';
				}

				$css .= $offsetX . 'px ';
				$css .= $offsetY . 'px ';
				$css .= $blurRadius . 'px ';
				$css .= $spreadRadius . 'px ';
				$css .= $color . ';' . PHP_EOL;

			}

			$this->_getAssetsRenderer()->createCssRule()->addParamsString( $css );

		}

	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected  function _renderRoundedCorners( $query ) {
		if( $query->queryExists('border-radius') ) {
			$br = $query->get('border-radius');
			$topLeft = $br->getWithoutComparationDefault('top-left', 0);
			$topRight = $br->getWithoutComparationDefault('top-right', 0);
			$bottomRight = $br->getWithoutComparationDefault('bottom-right', 0);
			$bottomLeft = $br->getWithoutComparationDefault('bottom-left', 0);

			$topLeft = $this->_addUnitToNumber( $topLeft );
			$topRight = $this->_addUnitToNumber( $topRight );
			$bottomLeft = $this->_addUnitToNumber( $bottomLeft );
			$bottomRight = $this->_addUnitToNumber( $bottomRight );

			$css = 'border-radius: ' . $topLeft . ' ' . $topRight . ' ' . $bottomRight . ' ' . $bottomLeft . ' !important;';

			$this->_getAssetsRenderer()->createCssRule()->addParamsString( $css );
		}
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderWidthAndHeight( $query ) {

		$breakpoints = $this->_getBreakpoints();

		$breakpointCounter = 0;

		$breakpointHeightArray = array();
		foreach( $breakpoints as $bp => $bpTitle ) {
			$breakpointCounter++;
			$queryName = 'wh-' . $bp;

			if( !$query->queryExists( $queryName ) ) {
				continue;
			}


			$bpQuery = $query->get( $queryName );

			$width = $bpQuery->getWithoutComparationDefault('w');
			$height = $bpQuery->getWithoutComparationDefault('h');

			$paramsArray = array();
			if( $width != null ) {
				$widthWithUnit = $this->_addUnitToNumber( $width );
				$paramsArray[] = 'width:' . $widthWithUnit .';';
			}

			if( $height != null ) {
				$heightWithUnit = $this->_addUnitToNumber( $height );
				$paramsArray[] = 'height:' . $heightWithUnit .';';

				$breakpointHeightArray[ $breakpointCounter ] = $height;

			}

			if( !empty( $paramsArray ) ) {
				$paramsString = implode(' ', $paramsArray );
				$this->_getAssetsRenderer()
					->createCssRule()
					->addBreakpointMin( $bp )
					->addParamsString( $paramsString );
			}


		}

		if( !empty( $breakpointHeightArray ) ) {

			$lastGoodBpValue = null;

			for( $i = 1; $i <= 4; $i++ ) {
				if( isset( $breakpointHeightArray[ $i ] ) ) {
					$lastGoodBpValue = $breakpointHeightArray[ $i ];
				} else {

					if( $lastGoodBpValue == null ) {
						$breakpointHeightArray[ $i ] = 'null';
					}  else {
						$breakpointHeightArray[ $i ] = $lastGoodBpValue;
					}

				}
			}
//			foreach( $breakpoints as $bp => $bpTitle ) {


//			}
			$breakpointHeight = json_encode( $breakpointHeightArray );

			$this->_getAssetsRenderer()->getElementHelper()->setAttribute('data-fg-height', htmlspecialchars($breakpointHeight) );
		}



//
//		foreach( $breakpoints as $bp => $bp_title ) {
//			$s->startSection( 'wh-'.$bp );
//
//			$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');
//
//			$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
//			$s->addElement(ffOneElement::TYPE_HTML, '', $bp_title);
//			$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');
//
//			$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
//			$s->addOption( ffOneOption::TYPE_TEXT, 'w', '', '')
//				->addParam('placeholder', 'Inherit')
//				->addParam('short', true);
//			$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');
//
//			$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
//			$s->addOption( ffOneOption::TYPE_TEXT, 'h', '', '')
//				->addParam('placeholder', 'Inherit')
//				->addParam('short', true);
//			$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');
//
//			$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');
//
//			$s->endSection();
//
//		}
//
//		$s->addElement(ffOneElement::TYPE_HTML, '', '</tbody></table>');

	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderMinHeight( $query ) {
		$breakpoints = $this->_getBreakpoints();
		$minHeight = array();
		$counter = 0;

		foreach( $breakpoints as $bp => $bpTitle ) {
			$counter++;
			if( !$query->queryExists('minh-' . $bp ) ) {
				continue;
			}

			$minh = $query->get('minh-' . $bp );

			$newMinHeight = array();
			$newMinHeight['height'] = $minh->getWithoutComparationDefault('height', '');
			$newMinHeight['offset'] = $minh->getWithoutComparationDefault('offset', '');

			$minHeight['breakpoint_' . $counter ] = $newMinHeight;
		}

		if( !empty( $minHeight ) ) {
			$minHeightString = json_encode( $minHeight );
			$this->_getAssetsRenderer()->getElementHelper()->setAttribute('data-fg-force-min-height', htmlspecialchars($minHeightString) );
		}
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderHideOn( $query ) {
		if( !$query->exists('hide') ) {
			return false;
		}

		$breakpoints = $this->_getBreakpoints();

		$hide = $query->get('hide');

		$element = $this->_getAssetsRenderer()->getElementHelper();

		foreach( $breakpoints as $bp => $bpTitle ) {
			$hideOnBp = $hide->getWithoutComparationDefault( $bp, 0);

			if( $hideOnBp ) {
				$element->addAttribute('class', 'hidden-'.$bp);
			}
		}

	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderAnimation( $query ) {
		if( !$query->exists('wow-animation') ) {
			return false;
		}

		$animation = $query->get('wow-animation');

		$type = $animation->getWithoutComparationDefault( 'type', '');
		$duration = $animation->getWithoutComparationDefault( 'duration', '');
		$delay = $animation->getWithoutComparationDefault( 'delay', '');

		$element = $this->_getAssetsRenderer()->getElementHelper();


		if( !empty( $type ) ) {
			$element->setAttribute('data-fg-wow', $type );
		} else {
			return;
		}

		if( !empty( $duration ) ) {
			$element->setAttribute('data-wow-duration', $duration . 's' );
		}

		if( !empty( $delay ) ) {
			$element->setAttribute('data-wow-delay', $delay . 's' );
		}

	}


	protected function _addUnitToNumber( $number ) {
		if( is_numeric( $number ) ) {
			$number = $number . 'px';
		}

		return $number;
	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {
		$s->startTab('Box Model', 'b-m', false, true);
		$s->addElement( ffOneElement::TYPE_TABLE_START );



			///////////////////////////////////////////////////////////////////////////////////////////////
			///// Backgrounds
			///////////////////////////////////////////////////////////////////////////////////////////////

			$this->_getBlock( ffThemeBuilderBlock::BACKGROUNDS)
				->setParam(ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $this->getParam( ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, false))
				->injectOptions( $s );



			///////////////////////////////////////////////////////////////////////////////////////////////
			///// Padding
			///////////////////////////////////////////////////////////////////////////////////////////////

			$breakpoints = $this->_getBreakpoints();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Padding');
				$s->addElement(ffOneElement::TYPE_HTML, '', '<table class="ffb-box-model-table" border="0" cellpadding="0" cellspacing="0">');

				$s->addElement(ffOneElement::TYPE_HTML, '', '<tbody><tr><td></td><td>Top</td><td>Right</td><td>Bottom</td><td>Left</td></tr>');

				foreach( $breakpoints as $bp => $bp_title ) {
					$s->startSection( 'pd-'.$bp );

						$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addElement(ffOneElement::TYPE_HTML, '', $bp_title);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 't', '', '')
									->addParam('placeholder', 'Inherit')
									->addParam('short', true);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 'r', '', '')
									->addParam('placeholder', 'Inherit')
									->addParam('short', true);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 'b', '', '')
									->addParam('placeholder', 'Inherit')
									->addParam('short', true);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 'l', '', '')
									->addParam('placeholder', 'Inherit')
									->addParam('short', true);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

						$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

					$s->endSection();

				}

				$s->addElement(ffOneElement::TYPE_HTML, '', '</tbody></table>');


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);



			///////////////////////////////////////////////////////////////////////////////////////////////
			///// Margin
			///////////////////////////////////////////////////////////////////////////////////////////////

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Margin');
				$s->addElement(ffOneElement::TYPE_HTML, '', '<table class="ffb-box-model-table" border="0" cellpadding="0" cellspacing="0">');

				$s->addElement(ffOneElement::TYPE_HTML, '', '<tbody><tr><td></td><td>Top</td><td>Right</td><td>Bottom</td><td>Left</td></tr>');

				foreach( $breakpoints as $bp => $bpCaption ) {
					$s->startSection( 'mg-'.$bp );

						$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addElement(ffOneElement::TYPE_HTML, '', $bpCaption);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 't', '', '')
									->addParam('placeholder', 'Inherit')
									->addParam('short', true);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 'r', '', '')
									->addParam('placeholder', 'Inherit')
									->addParam('short', true);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 'b', '', '')
									->addParam('placeholder', 'Inherit')
									->addParam('short', true);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 'l', '', '')
									->addParam('placeholder', 'Inherit')
									->addParam('short', true);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

						$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

					$s->endSection();
				}

				$s->addElement(ffOneElement::TYPE_HTML, '', '</tbody></table>');


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);



			///////////////////////////////////////////////////////////////////////////////////////////////
			///// Borders
			///////////////////////////////////////////////////////////////////////////////////////////////



			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Borders');

				$s->startSection('borders', ffOneSection::TYPE_REPEATABLE_VARIABLE )
					->addParam('can-be-empty', true)
					->addParam('work-as-accordion', true)
					->addParam('all-items-opened', true);

					$s->startSection('one-border', ffOneSection::TYPE_REPEATABLE_VARIATION)
						->addParam('section-name', 'Border')
						->addParam('hide-default', true)
					;

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type', '', 'border-all')
							->addSelectValue('border', 'border-all')
							->addSelectValue('border-top', 'border-top')
							->addSelectValue('border-right', 'border-right')
							->addSelectValue('border-bottom', 'border-bottom')
							->addSelectValue('border-left', 'border-left')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Border Type');

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'width', '', '1')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Border Width (in px)');

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'style', '', 'solid')
							->addSelectValue('solid', 'solid')
							->addSelectValue('dashed', 'dashed')
							->addSelectValue('dotted', 'dotted')
							->addSelectValue('double', 'double')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Border Style');

						$s->addOption( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', 'rgba(128,128,128,0.4)')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Border Color');

					$s->endSection();

				$s->endSection();


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);



			///////////////////////////////////////////////////////////////////////////////////////////////
			///// Box Shadows
			///////////////////////////////////////////////////////////////////////////////////////////////



			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Box Shadows');

				$s->startSection('box-shadows', ffOneSection::TYPE_REPEATABLE_VARIABLE )
					->addParam('can-be-empty', true)
					->addParam('work-as-accordion', true)
					->addParam('all-items-opened', true);

					$s->startSection('one-box-shadow', ffOneSection::TYPE_REPEATABLE_VARIATION)
						->addParam('section-name', 'Box Shadow')
						->addParam('hide-default', true)
					;

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'set', '', 'outer')
							->addSelectValue('outer', 'outer')
							->addSelectValue('inset', 'inset')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Shadow Type');

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'offset-x', '', '0')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Horizontal Offset (in px)');

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'offset-y', '', '3')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Vertical Offset (in px)');

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'blur-radius', '', '5')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Blur Radius (in px)');

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'spread-radius', '', '0')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Spread Radius (in px)');

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', 'rgba(0,0,0,0.18)')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Shadow Color');

					$s->endSection();

				$s->endSection();


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);



			///////////////////////////////////////////////////////////////////////////////////////////////
			///// Rounded Corners
			///////////////////////////////////////////////////////////////////////////////////////////////



			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Border Radius');
				$s->startSection('border-radius');

					$s->addElement(ffOneElement::TYPE_HTML, '', '<table class="ffb-box-model-table" border="0" cellpadding="0" cellspacing="0">');

					$s->addElement(ffOneElement::TYPE_HTML, '', '<tbody><tr><td></td><td>Top Left</td><td>Top Right</td><td>Bottom Right</td><td>Bottom Left</td></tr>');

					$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

					$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
						$s->addElement(ffOneElement::TYPE_HTML, '', 'Radius');
					$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

					$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
						$s->addOption( ffOneOption::TYPE_TEXT, 'top-left', '', '')
							->addParam('short', true);
					$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

					$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
						$s->addOption( ffOneOption::TYPE_TEXT, 'top-right', '', '')
							->addParam('short', true);
					$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

					$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
						$s->addOption( ffOneOption::TYPE_TEXT, 'bottom-right', '', '')
							->addParam('short', true);
					$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

					$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
						$s->addOption( ffOneOption::TYPE_TEXT, 'bottom-left', '', '')
							->addParam('short', true);
					$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

					$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

					$s->addElement(ffOneElement::TYPE_HTML, '', '</tbody></table>');

				$s->endSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);



			///////////////////////////////////////////////////////////////////////////////////////////////
			///// Reveal Animation
			///////////////////////////////////////////////////////////////////////////////////////////////


			// <div data-fg-wow="fadeIn" data-wow-duration="2s" data-wow-delay="5s"> Do not print duration/delay if they are not set


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Reveal Animation');

				$s->startSection('wow-animation');

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type', '', '')
					->addSelectValue('', '')
					->addSelectValue('bounce', 'bounce')
					->addSelectValue('flash', 'flash')
					->addSelectValue('pulse', 'pulse')
					->addSelectValue('rubberBand', 'rubberBand')
					->addSelectValue('shake', 'shake')
					->addSelectValue('headShake', 'headShake')
					->addSelectValue('swing', 'swing')
					->addSelectValue('tada', 'tada')
					->addSelectValue('wobble', 'wobble')
					->addSelectValue('jello', 'jello')
					->addSelectValue('bounceIn', 'bounceIn')
					->addSelectValue('bounceInDown', 'bounceInDown')
					->addSelectValue('bounceInLeft', 'bounceInLeft')
					->addSelectValue('bounceInRight', 'bounceInRight')
					->addSelectValue('bounceInUp', 'bounceInUp')
					->addSelectValue('bounceOut', 'bounceOut')
					->addSelectValue('bounceOutDown', 'bounceOutDown')
					->addSelectValue('bounceOutLeft', 'bounceOutLeft')
					->addSelectValue('bounceOutRight', 'bounceOutRight')
					->addSelectValue('bounceOutUp', 'bounceOutUp')
					->addSelectValue('fadeIn', 'fadeIn')
					->addSelectValue('fadeInDown', 'fadeInDown')
					->addSelectValue('fadeInDownBig', 'fadeInDownBig')
					->addSelectValue('fadeInLeft', 'fadeInLeft')
					->addSelectValue('fadeInLeftBig', 'fadeInLeftBig')
					->addSelectValue('fadeInRight', 'fadeInRight')
					->addSelectValue('fadeInRightBig', 'fadeInRightBig')
					->addSelectValue('fadeInUp', 'fadeInUp')
					->addSelectValue('fadeInUpBig', 'fadeInUpBig')
					->addSelectValue('fadeOut', 'fadeOut')
					->addSelectValue('fadeOutDown', 'fadeOutDown')
					->addSelectValue('fadeOutDownBig', 'fadeOutDownBig')
					->addSelectValue('fadeOutLeft', 'fadeOutLeft')
					->addSelectValue('fadeOutLeftBig', 'fadeOutLeftBig')
					->addSelectValue('fadeOutRight', 'fadeOutRight')
					->addSelectValue('fadeOutRightBig', 'fadeOutRightBig')
					->addSelectValue('fadeOutUp', 'fadeOutUp')
					->addSelectValue('fadeOutUpBig', 'fadeOutUpBig')
					->addSelectValue('flipInX', 'flipInX')
					->addSelectValue('flipInY', 'flipInY')
					->addSelectValue('flipOutX', 'flipOutX')
					->addSelectValue('flipOutY', 'flipOutY')
					->addSelectValue('lightSpeedIn', 'lightSpeedIn')
					->addSelectValue('lightSpeedOut', 'lightSpeedOut')
					->addSelectValue('rotateIn', 'rotateIn')
					->addSelectValue('rotateInDownLeft', 'rotateInDownLeft')
					->addSelectValue('rotateInDownRight', 'rotateInDownRight')
					->addSelectValue('rotateInUpLeft', 'rotateInUpLeft')
					->addSelectValue('rotateInUpRight', 'rotateInUpRight')
					->addSelectValue('rotateOut', 'rotateOut')
					->addSelectValue('rotateOutDownLeft', 'rotateOutDownLeft')
					->addSelectValue('rotateOutDownRight', 'rotateOutDownRight')
					->addSelectValue('rotateOutUpLeft', 'rotateOutUpLeft')
					->addSelectValue('rotateOutUpRight', 'rotateOutUpRight')
					->addSelectValue('hinge', 'hinge')
					->addSelectValue('rollIn', 'rollIn')
					->addSelectValue('rollOut', 'rollOut')
					->addSelectValue('zoomIn', 'zoomIn')
					->addSelectValue('zoomInDown', 'zoomInDown')
					->addSelectValue('zoomInLeft', 'zoomInLeft')
					->addSelectValue('zoomInRight', 'zoomInRight')
					->addSelectValue('zoomInUp', 'zoomInUp')
					->addSelectValue('zoomOut', 'zoomOut')
					->addSelectValue('zoomOutDown', 'zoomOutDown')
					->addSelectValue('zoomOutLeft', 'zoomOutLeft')
					->addSelectValue('zoomOutRight', 'zoomOutRight')
					->addSelectValue('zoomOutUp', 'zoomOutUp')
					->addSelectValue('slideInDown', 'slideInDown')
					->addSelectValue('slideInLeft', 'slideInLeft')
					->addSelectValue('slideInRight', 'slideInRight')
					->addSelectValue('slideInUp', 'slideInUp')
					->addSelectValue('slideOutDown', 'slideOutDown')
					->addSelectValue('slideOutLeft', 'slideOutLeft')
					->addSelectValue('slideOutRight', 'slideOutRight')
					->addSelectValue('slideOutUp', 'slideOutUp')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Animation');

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'duration', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Duration (in seconds)');

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'delay', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Delay (in seconds)');

				$s->endSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);



			///////////////////////////////////////////////////////////////////////////////////////////////
			///// Dimensions
			///////////////////////////////////////////////////////////////////////////////////////////////

			$breakpoints = $this->_getBreakpoints();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Dimensions');
				$s->addElement(ffOneElement::TYPE_HTML, '', '<table class="ffb-box-model-table" border="0" cellpadding="0" cellspacing="0">');

				$s->addElement(ffOneElement::TYPE_HTML, '', '<tbody><tr><td></td><td>Width</td><td>Height</td></tr>');

				foreach( $breakpoints as $bp => $bp_title ) {
					$s->startSection( 'wh-'.$bp );

						$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addElement(ffOneElement::TYPE_HTML, '', $bp_title);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 'w', '', '')
									->addParam('placeholder', 'Inherit')
									->addParam('short', true);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 'h', '', '')
									->addParam('placeholder', 'Inherit')
									->addParam('short', true);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

						$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

					$s->endSection();

				}

				$s->addElement(ffOneElement::TYPE_HTML, '', '</tbody></table>');


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);



			///////////////////////////////////////////////////////////////////////////////////////////////
			///// Force Minimal Height
			///////////////////////////////////////////////////////////////////////////////////////////////



			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Force Minimal Height');

				$default_values = array(
					'xs' => '' ,
					'sm' => '' ,
					'md' => '' ,
					'lg' => '' ,
				);

				$s->addElement(ffOneElement::TYPE_HTML, '', '<table class="ffb-box-model-table" border="0" cellpadding="0" cellspacing="0">');

				$s->addElement(ffOneElement::TYPE_HTML, '', '<tbody><tr><td></td><td>Height Relative to Window</td><td>Offset</td></tr>');

				foreach( $breakpoints as $bp => $bp_title ) {
					$s->startSection('minh-' . $bp );

						$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

						$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
							$s->addElement(ffOneElement::TYPE_HTML, '', $bp_title);
						$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

						$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');

							$s->addOption( ffOneOption::TYPE_TEXT, 'height', '', '');

						$s->addElement(ffOneElement::TYPE_HTML, '', ' % &nbsp;&nbsp;&nbsp;');
						$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

						$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');

							$s->addOption( ffOneOption::TYPE_TEXT, 'offset', '', '');

						$s->addElement(ffOneElement::TYPE_HTML, '', ' px ');
						$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

						$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

					$s->endSection();

				}

				$s->addElement(ffOneElement::TYPE_HTML, '', '</tbody></table>');

				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'You can force a minimal height on this element relative to the browser window height. First set the percentage value that is based on the window height and then set a fixed offset value (if needed, it is not necessary) that can be either positive or negative. If the content inside this element exceeds the set minimal height, then the wrapping element will naturally expand to prevent any content clipping.<br><br> Example window height: 1000px<br> Example 1: <code>100%</code>. Final calculated min height will be: 1000px.<br> Example 2: <code>50% + 50px</code>. Final calculated min height will be: 550px.<br> Example 3: <code>70% - 1px</code>. Final calculated min height will be: 699px.');

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);



			///////////////////////////////////////////////////////////////////////////////////////////////
			///// Visibility
			///////////////////////////////////////////////////////////////////////////////////////////////



			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Visibility');
				$s->startSection('hide');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'xs', 'Hide on Phone (XS)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'sm', 'Hide on Tablet (SM)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'md', 'Hide on Laptop (MD)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'lg', 'Hide on Desktop (LG)', 0);
				$s->endSection();
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