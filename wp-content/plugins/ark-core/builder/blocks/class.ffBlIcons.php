<?php

class ffBlIcons extends ffThemeBuilderBlockBasic {
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
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'icons');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'icn');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_APPLY_CALLBACKS, true);
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

	protected function _renderColor( $query, $cssAttribute, $cssAfterAttribute = null, $selector = null ) {
		if( $query && $selector ){
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .' '. $cssAfterAttribute .';');
		} else if( $query ){
			$this->_getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}
	}

	protected function _render( $query ){

		$icons = $query->getWithoutComparation('icons');

		if( empty($icons) ){
			return;
		}

		$display = $query->getWithoutComparation('display', 'list-inline');
		if( empty($display) ){
			$display = 'list-inline';
		}

		echo '<ul class="'. esc_attr($display) .'">';

		foreach( $icons as $key => $oneItem ) {

			$this->_renderColor( $oneItem->getColorWithoutComparationDefault('icon-color', '#ffffff'), 'color', null, 'ff-custom-color');
			$this->_renderColor( $oneItem->getColorWithoutComparationDefault('icon-hover-color', '#ffffff'), 'color', '!important', 'ff-custom-color:hover');

			if( $oneItem->getColorWithoutComparationDefault('border-color', '') ){

				$this->_renderColor( $oneItem->getColorWithoutComparationDefault('border-color', ''), 'border-color', null, 'ff-custom-color');
			} else {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector('ff-custom-color')
					->addParamsString( 'border-color: transparent;');
			}
			if( $oneItem->getColorWithoutComparationDefault('border-hover-color', '') ){
				$this->_renderColor( $oneItem->getColorWithoutComparationDefault('border-hover-color', ''), 'border-color', null, 'ff-custom-color:hover');
			} else {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector('ff-custom-color:hover')
					->addParamsString( 'border-color: transparent;');
			}

			$this->_renderColor( $oneItem->getColorWithoutComparationDefault('bg-color', '#44619d'), 'background-color', null, 'ff-custom-color');
			$this->_renderColor( $oneItem->getColorWithoutComparationDefault('bg-hover-color', '#00bcd4'), 'background-color', null, 'ff-custom-color:hover');

			$wrapperTag = 'span';


			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneItem ) ) {
				$wrapperTag = 'a';
			}

			switch( $oneItem->getVariationType() ){

				case 'icon1':
					echo '<li class="theme-icons-wrap">';
						echo '<'.$wrapperTag.' ';
							$this->_getBlock( ffThemeBuilderBlock::LINK )->render( $oneItem );
						echo '>';
							echo '<i class="theme-icons ff-custom-color theme-icons-'
								. esc_attr( $oneItem->getWithoutComparationDefault('size', 'sm') ) . ' '
								. esc_attr( $oneItem->getWithoutComparationDefault('radius', '') ) . ' '
								. esc_attr( $oneItem->getWithoutComparationDefault('icon', 'ff-font-awesome4 icon-facebook' ) ) .' '
								. ($oneItem->getWithoutComparationDefault('use-shadow', 0) ? 'animate-icon-item-shadow':'') .' '
								. ($oneItem->getWithoutComparationDefault('use-border', 0) ? 'border-solid':'') .'"></i>';

						echo '</'.$wrapperTag.'>';
					echo '</li>';
					break;

				case 'icon2':

					$this->_renderColor( $oneItem->getColorWithoutComparationDefault('icon-hover-color', '#ffffff'), 'color', null, 'icon-tooltip');
					$this->_renderColor( $oneItem->getColorWithoutComparationDefault('bg-hover-color', '#00bcd4'), 'background-color', null, 'icon-tooltip');
					$this->_renderColor( $oneItem->getColorWithoutComparationDefault('bg-hover-color', '#00bcd4'), 'border-color', null, 'icon-tooltip-arrow');

					echo '<li class="animate-icon">';
						echo '<'.$wrapperTag.' ';
							$this->_getBlock( ffThemeBuilderBlock::LINK )
								->setParam('classes',
									'ff-custom-color animate-icon-wrap animate-icon-'
									. esc_attr( $oneItem->getWithoutComparationDefault('size', 'sm') ) . ' '
									. esc_attr( $oneItem->getWithoutComparationDefault('radius', '') ) . ' '
									. ($oneItem->getWithoutComparationDefault('use-shadow', 0) ? 'animate-icon-item-shadow':'') .' '
									. ($oneItem->getWithoutComparationDefault('use-border', 0) ? 'border-solid':'')
								)->render( $oneItem );
						echo '>';

							echo '<i class="animate-icon-item ' . $oneItem->getWithoutComparationDefault('icon', 'ff-font-awesome4 icon-facebook') .'"></i>';
							echo '<i class="animate-icon-item ' . $oneItem->getWithoutComparationDefault('icon', 'ff-font-awesome4 icon-facebook') .'"></i>';

							if( $oneItem->getWithoutComparationDefault('use-tooltip', 0) ){
								$tooltipExtra = '';

								if( 'list-block' == $query->getWithoutComparationDefault('display', 'list-inline') ) {
									$tooltipExtra = 'ff-icon-tooltip-'. $oneItem->getEscAttr('position') .'-block';
								}

								echo '<div class="icon-tooltip icon-tooltip-'. esc_attr( $oneItem->getWithoutComparationDefault('position', 'top') ) .' '.$tooltipExtra.'  radius-3">';
									echo ark_wp_kses( $oneItem->getWithoutComparationDefault('label', 'Follow me on Facebook') );
									echo '<div class="icon-tooltip-arrow icon-tooltip-arrow-'. esc_attr( $oneItem->getWithoutComparationDefault('position', 'top') ) .' "></div>';
								echo '</div>';
							}

						echo '</'.$wrapperTag.'>';
					echo '</li>';
					break;

				case 'icon3':
					echo '<li class="animate-icon">';

						$radius = $oneItem->getWithoutComparationDefault('radius','');
						$border = $oneItem->getWithoutComparationDefault('border','');
						$animation = $oneItem->getWithoutComparationDefault('animation','animate-icon-left-to-right');
						$icon = $oneItem->getWithoutComparationDefault('icon','ff-font-et-line icon-briefcase');

						echo '<'.$wrapperTag.' ';
						if( 'radius-circle' == $radius && 'brd-double-square' == $border ){
							$this->_getBlock( ffThemeBuilderBlock::LINK )
								->setParam('classes','ff-custom-color animate-icon-horizontal font-size-36 brd-double-circle radius-circle')
								->render( $oneItem );
						} else {
							$this->_getBlock( ffThemeBuilderBlock::LINK )
								->setParam('classes','ff-custom-color animate-icon-horizontal font-size-36 '. esc_attr($border) .' '. esc_attr($radius) )
								->render( $oneItem );
						}
						echo '>';

							echo '<i class="animate-icon-horizontal-wrap '. esc_attr($animation) .' '. esc_attr($icon) .'"></i>';
							echo '<i class="animate-icon-horizontal-wrap '. esc_attr($animation) .' '. esc_attr($icon) .'"></i>';

						echo '</'.$wrapperTag.'>';
					echo '</li>';
					break;

				case 'icon4':

					echo '<li class="theme-icons-elegant '. esc_attr($oneItem->getWithoutComparationDefault('layout', 'theme-icons-elegant-right')) .'">';

						echo '<div class="theme-icons-element">';
							echo '<div class="theme-icons-wrap">';
								echo '<'.$wrapperTag.' ';
									$this->_getBlock( ffThemeBuilderBlock::LINK )->render( $oneItem );
								echo '>';

									echo '<i class="theme-icons ff-custom-color theme-icons-'
										. esc_attr( $oneItem->getWithoutComparationDefault('size', 'sm') ) . ' '
										. esc_attr( $oneItem->getWithoutComparationDefault('radius', '') ) . ' '
										. esc_attr( $oneItem->getWithoutComparationDefault('icon', 'ff-font-awesome4 icon-facebook' ) ) .' '
										. ($oneItem->getWithoutComparationDefault('use-shadow', 0) ? 'animate-icon-item-shadow':'') .' '
										. ($oneItem->getWithoutComparationDefault('use-border', 0) ? 'border-solid':'')
										. '"></i>';

								echo '</'.$wrapperTag.'>';
							echo '</div>';
						echo '</div>';

						if( $oneItem->exists('content') ){
							echo '<div class="theme-icons-body">';
								foreach( $oneItem->get('content') as $oneLabel ){
									switch( $oneLabel->getVariationType() ) {
										case 'title':
											echo '<span class="theme-icons-body-title text-uppercase">';
											echo ark_wp_kses( $oneLabel->getWithoutComparationDefault('text', 'FACEBOOK') );
											echo '</span>';
											break;
										case 'description':
											echo '<p class="them-icon-body-paragraph">';
											echo ark_wp_kses( $oneLabel->getWithoutComparationDefault('text', 'Keep in touch & Share') );
											echo '</p>';
											break;
									}
								}
							echo '</div>';
						}

					echo '</li>';
					break;

			}
		}

		echo '</ul>';

	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->startRepVariableSection('icons');

			/****************************************************************************************/
			/* ICON 1
			/****************************************************************************************/
			$s->startRepVariationSection('icon1', ark_wp_kses( __('Icon (Type 1, Static)', 'ark' ) ) )
				->addParam('hide-default', true);

				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Settings', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-facebook')
						->addParam('print-in-content', true)
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE );

					$s->addOptionNL(ffOneOption::TYPE_SELECT, 'size', '', 'sm')
						->addSelectValue( esc_attr( __('Extra small', 'ark' ) ), 'xs')
						->addSelectValue( esc_attr( __('Small', 'ark' ) ), 'sm')
						->addSelectValue( esc_attr( __('Medium', 'ark' ) ), 'md')
						->addSelectValue( esc_attr( __('Large', 'ark' ) ), 'lg')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Size', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_SELECT, 'radius', '', '')
						->addSelectValue( esc_attr( __('No radius', 'ark' ) ), '')
						->addSelectValue( esc_attr( __('Small (3px)', 'ark' ) ), 'radius-3')
						->addSelectValue( esc_attr( __('Medium (6px)', 'ark' ) ), 'radius-6')
						->addSelectValue( esc_attr( __('Full circle', 'ark' ) ), 'radius-circle')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Radius', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-shadow',ark_wp_kses( __('Apply shadow decoration', 'ark' ) ),0);
					$s->addOption(ffOneOption::TYPE_CHECKBOX,'use-border',ark_wp_kses( __('Apply border decoration', 'ark' ) ),0);
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

				/* LINK */
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Settings', 'ark' ) ) );
					$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

				/* COLORS */
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Icon Colors', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '' , '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '' , '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER,  ark_wp_kses( __('Border', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '' , '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('If you want to set border colors you first need to check the <strong>Apply border decoration</strong> option in the Basic Settings above.', 'ark' ) ) );
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '' , '#44619d')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '' , '#00bcd4')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover', 'ark' ) ) )
					;
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

			$s->endRepVariationSection();

			/****************************************************************************************/
			/* ICON 2
			/****************************************************************************************/
			$s->startRepVariationSection('icon2', ark_wp_kses( __('Icon (Type 2, Top animation)', 'ark' ) ) )
				->addParam('hide-default', true);

				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Settings', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-facebook')
						->addParam('print-in-content', true)
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE );

					$s->addOptionNL(ffOneOption::TYPE_SELECT, 'size', '', 'sm')
						->addSelectValue( esc_attr( __('Extra small', 'ark' ) ), 'xs')
						->addSelectValue( esc_attr( __('Small', 'ark' ) ), 'sm')
						->addSelectValue( esc_attr( __('Medium', 'ark' ) ), 'md')
						->addSelectValue( esc_attr( __('Large', 'ark' ) ), 'lg')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Size', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_SELECT, 'radius', '', '')
						->addSelectValue( esc_attr( __('No radius', 'ark' ) ), '')
						->addSelectValue( esc_attr( __('Small (3px)', 'ark' ) ), 'radius-3')
						->addSelectValue( esc_attr( __('Medium (6px)', 'ark' ) ), 'radius-6')
						->addSelectValue( esc_attr( __('Full circle', 'ark' ) ), 'radius-circle')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Radius', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-shadow',ark_wp_kses( __('Apply shadow decoration', 'ark' ) ),0);
					$s->addOption(ffOneOption::TYPE_CHECKBOX,'use-border',ark_wp_kses( __('Apply border decoration', 'ark' ) ),0);

				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);


				/* LINK */
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Settings', 'ark' ) ) );
					$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

				/* COLORS */
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Icon Colors', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '' , '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '' , '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '' , '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '' , '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('If you want to set border colors you first need to check the <strong>Apply border decoration</strong> option in the Basic Settings above.', 'ark' ) ) );
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '' , '#44619d')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '' , '#00bcd4')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover', 'ark' ) ) )
					;
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

				/* TOOLTIP */
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Tooltip', 'ark' ) ) );
					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-tooltip',ark_wp_kses( __('Apply tooltip', 'ark' ) ),0);
					$s->addOptionNL(ffOneOption::TYPE_SELECT, 'position', '', 'top')
						->addSelectValue( esc_attr( __('Top', 'ark' ) ), 'top')
						->addSelectValue( esc_attr( __('Bottom', 'ark' ) ), 'bottom')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Position', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_TEXT,'label','','Follow me on Facebook')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label', 'ark' ) ) )
					;
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

			$s->endRepVariationSection();


			/****************************************************************************************/
			/* ICON 3
			/****************************************************************************************/
			$s->startRepVariationSection('icon3', ark_wp_kses( __('Icon (Type 3, Side animation)', 'ark' ) ) )
				->addParam('hide-default', true);

					$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Settings', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-briefcase')
							->addParam('print-in-content', true)
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE );

						$s->addOptionNL(ffOneOption::TYPE_SELECT, 'animation', '', 'animate-icon-left-to-right')
							->addSelectValue( esc_attr( __('Left to right', 'ark' ) ), 'animate-icon-left-to-right')
							->addSelectValue( esc_attr( __('Right to left', 'ark' ) ), 'animate-icon-right-to-left')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Animation', 'ark' ) ) )
						;
						$s->addOptionNL(ffOneOption::TYPE_SELECT, 'border', '', '')
							->addSelectValue( esc_attr( __('None', 'ark' ) ), '')
							->addSelectValue( esc_attr( __('Classic', 'ark' ) ), 'brd-solid')
							->addSelectValue( esc_attr( __('Dashed', 'ark' ) ), 'brd-dashed')
							->addSelectValue( esc_attr( __('Dotted', 'ark' ) ), 'brd-dotted')
							->addSelectValue( esc_attr( __('Double', 'ark' ) ), 'brd-double-square')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border type', 'ark' ) ) )
						;
						$s->addOptionNL(ffOneOption::TYPE_SELECT, 'radius', '', '')
							->addSelectValue( esc_attr( __('No radius', 'ark' ) ), '')
							->addSelectValue( esc_attr( __('Small (3px)', 'ark' ) ), 'radius-3')
							->addSelectValue( esc_attr( __('Medium (6px)', 'ark' ) ), 'radius-6')
							->addSelectValue( esc_attr( __('Full circle', 'ark' ) ), 'radius-circle')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Radius', 'ark' ) ) )
						;
					$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

					/* LINK */
					$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Settings', 'ark' ) ) );
						$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
					$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

					/* COLORS */
					$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Icon Colors', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '' , '#3A3A43')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#3A3A43')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '' , '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER,  ark_wp_kses( __('Border', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '' , '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('If you want to set border colors first you need to select the <strong>Border type</strong> option in the Basic Settings above.', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '' , '#44619d')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '' , '#00bcd4')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover', 'ark' ) ) )
						;
					$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

			$s->endRepVariationSection();

			/****************************************************************************************/
			/* ICON 4
			/****************************************************************************************/
			$s->startRepVariationSection('icon4', ark_wp_kses( __('Icon (Type 4, Static with Labels)', 'ark' ) ) )
				->addParam('hide-default', true);

				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Settings', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-facebook')
						->addParam('print-in-content', true)
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE );

					$s->addOptionNL(ffOneOption::TYPE_SELECT, 'size', '', 'sm')
						->addSelectValue( esc_attr( __('Extra small', 'ark' ) ), 'xs')
						->addSelectValue( esc_attr( __('Small', 'ark' ) ), 'sm')
						->addSelectValue( esc_attr( __('Medium', 'ark' ) ), 'md')
						->addSelectValue( esc_attr( __('Large', 'ark' ) ), 'lg')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Size', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_SELECT, 'radius', '', '')
						->addSelectValue( esc_attr( __('No radius', 'ark' ) ), '')
						->addSelectValue( esc_attr( __('Small (3px)', 'ark' ) ), 'radius-3')
						->addSelectValue( esc_attr( __('Medium (6px)', 'ark' ) ), 'radius-6')
						->addSelectValue( esc_attr( __('Full circle', 'ark' ) ), 'radius-circle')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Radius', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-shadow',ark_wp_kses( __('Apply shadow decoration', 'ark' ) ),0);
					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-border',ark_wp_kses( __('Apply border decoration', 'ark' ) ),0);

					$s->addElement(ffOneElement::TYPE_NEW_LINE );
					$s->addOptionNL(ffOneOption::TYPE_SELECT, 'layout', '', 'theme-icons-elegant-right')
						->addSelectValue( esc_attr( __('Icon on the Right, Labels on the Left', 'ark' ) ), 'theme-icons-elegant-right')
						->addSelectValue( esc_attr( __('Icon on the Left, Labels on the Right', 'ark' ) ), '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Layout', 'ark' ) ) )
					;

					/* LABELS */
					$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Labels', 'ark' ) ) );

						$s->startRepVariableSection('content');

							/* TYPE TITLE */
							$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'FACEBOOK')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
							$s->endRepVariationSection();

							/* TYPE DESCRIPTION */
							$s->startRepVariationSection('description', ark_wp_kses( __('Description', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Keep in touch & Share')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

				/* LINK */
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Settings', 'ark' ) ) );
					$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

				/* COLORS */
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Icon Colors', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '' , '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '' , '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER,  ark_wp_kses( __('Border', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '' , '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('If you want to set border colors you first need to check the <strong>Apply border decoration</strong> option in the Basic Settings above.', 'ark' ) ) );
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '' , '#44619d')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '' , '#00bcd4')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover', 'ark' ) ) )
					;
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

			$s->endRepVariationSection();

		$s->endRepVariableSection();

		$s->addElement(ffOneElement::TYPE_NEW_LINE );

		$s->addOptionNL(ffOneOption::TYPE_SELECT, 'display', '', 'list-inline')
			->addSelectValue( esc_attr( __('Inline', 'ark' ) ), 'list-inline')
			->addSelectValue( esc_attr( __('Block', 'ark' ) ), 'list-unstyled')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icons Display Style', 'ark' ) ) )
		;
		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('<strong>Inline</strong> style puts icons next to each other.', 'ark' ) ) );
		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('<strong>Block</strong> style puts icons under each other.', 'ark' ) ) );

	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, params ) {

				if( query == null || !query.exists('icons') ) {
				} else {
					query.get('icons').each(function (query, variationType) {
						query.addIcon('icon');
					});
				}
			}
		</script data-type="ffscript">
	<?php
	}
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}