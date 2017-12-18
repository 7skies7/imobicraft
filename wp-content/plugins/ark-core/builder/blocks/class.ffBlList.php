<?php

class ffBlList extends ffThemeBuilderBlockBasic {
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
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'list');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'lst');
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


	protected function _render( $query ){

		$list = $query->getWithoutComparation('list');

		if( empty($list) ){
			return;
		}

		echo '<ul class="ffb-list lists-base">';

			foreach( $list as $key => $oneItem ) {
				switch( $oneItem->getVariationType() ){
					case 'list-item':

						$align = $oneItem->getWithoutComparationDefault('align', 'text-left');

						$type = $oneItem->getWithoutComparationDefault('type', 'icon');

						$listStyle = 'ffb-list-style-normal ffb-list-mark-'.$type;
						if ( $type == 'icon' ) 	{
							$listStyle = 'ffb-list-style-icon list-unstyled';
						}

						if ($oneItem->getColorWithoutComparationDefault('marker-color','')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.ffb-list-item', false)
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('marker-color','').';');
						}

						echo '<li class="ffb-list-item '.$align.' '.$listStyle.'">';

							if( $type == 'icon' ){
								$this->_advancedToggleBoxStart($oneItem,'one-icon');

									$icon = $oneItem->getWithoutComparationDefault('one-icon icon', 'ff-font-awesome4 icon-angle-right');

									if ($oneItem->getColorWithoutComparationDefault('one-icon icon-color','')) {
										$this->_getAssetsRenderer()->createCssRule()
											->setAddWhiteSpaceBetweenSelectors(false)
											->addSelector(' .ffb-list-icon', false)
											->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('one-icon icon-color','').';');
									}

									if ($oneItem->getColorWithoutComparationDefault('one-icon icon-bg-color','')) {
										$this->_getAssetsRenderer()->createCssRule()
											->setAddWhiteSpaceBetweenSelectors(false)
											->addSelector(' .ffb-list-icon', false)
											->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('one-icon icon-bg-color','').';');
									}

									$iconBorder = '';

									if ($oneItem->getColorWithoutComparationDefault('one-icon icon-border-color','')) {
										$iconBorder = 'ffb-list-icon-has-border';
										$this->_getAssetsRenderer()->createCssRule()
											->setAddWhiteSpaceBetweenSelectors(false)
											->addSelector(' .ffb-list-icon', false)
											->addParamsString('border: 1px solid ' . $oneItem->getColorWithoutComparationDefault('one-icon icon-border-color','').';');
									}

									echo '<i class="ffb-list-icon '.$icon.' '.$iconBorder.'"></i>';

								$this->_advancedToggleBoxEnd($oneItem,'one-icon');
							}

								$this->_advancedToggleBoxStart($oneItem,'one-text');

									if ($oneItem->getColorWithoutComparationDefault('one-text text-color','')) {
										$this->_getAssetsRenderer()->createCssRule()
											->setAddWhiteSpaceBetweenSelectors(false)
											->addSelector(' .ffb-list-text', false)
											->addParamsString('color: ' . $oneItem->getColorWithoutComparationDefault('one-text text-color','').';');
									}

									$text = $oneItem->getWithoutComparationDefault('one-text item-text', 'Lorem ipsum dolor sit amet');
									echo '<div class="ffb-list-text">';

										if ($oneItem->getColorWithoutComparationDefault('link-color','')) {
											$this->_getAssetsRenderer()->createCssRule()
												->setAddWhiteSpaceBetweenSelectors(false)
												->addSelector(' a', false)
												->addParamsString('color: ' . $oneItem->getColorWithoutComparationDefault('link-color','').';');
										}

										if ($oneItem->getColorWithoutComparationDefault('link-hover-color','')) {
											$this->_getAssetsRenderer()->createCssRule()
												->setAddWhiteSpaceBetweenSelectors(false)
												->addSelector(' a:hover', false)
												->addParamsString('color: ' . $oneItem->getColorWithoutComparationDefault('link-hover-color','').';');
										}
									
										if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneItem ) ) {

											echo '<a ';
											$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam('classes', 'ffb-list-link')->render($oneItem);
											echo ' >';
										}

											echo ark_wp_kses( $text );

										if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneItem ) ) {
											echo '</a>';
										}


									echo '</div>';
								$this->_advancedToggleBoxEnd($oneItem,'one-text');
						

						echo '</li>';

						break;

					}
			}

		echo '</ul>';
	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->startRepVariableSection('list');

			/****************************************************************************************/
			/* LIST
			/****************************************************************************************/
			$s->startRepVariationSection('list-item', ark_wp_kses( __('List Item', 'ark' ) ) )
				->addParam('hide-default', true);

				/* TEXT */
				$s->startAdvancedToggleBox('one-text', esc_attr( __('Text', 'ark' ) ));

					$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'item-text', '', 'Lorem ipsum dolor sit amet')
						->addParam('print-in-content', true)
					;

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) )
					;

				$s->endAdvancedToggleBox();

				/* LINK */
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Settings', 'ark' ) ) );

					$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-color', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Color', 'ark' ) ) )
					;

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-hover-color', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Hover Color', 'ark' ) ) )
					;

				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

				/* STYLE */
				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('List Style', 'ark' ) ) );

					$s->addOptionNL(ffOneOption::TYPE_SELECT,'align','','text-left')
						->addSelectValue('Left','text-left')
						->addSelectValue('Center','text-center')
						->addSelectValue('Right','text-right')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Align', 'ark' ) ) )
					;

					$s->addOptionNL(ffOneOption::TYPE_SELECT, 'type', '', 'icon')
						->addSelectValue( esc_attr( __('Icon', 'ark' ) ), 'icon')
						->addSelectValue( esc_attr( __('Disc', 'ark' ) ), 'disc')
						->addSelectValue( esc_attr( __('Circle', 'ark' ) ), 'circle')
						->addSelectValue( esc_attr( __('Decimal', 'ark' ) ), 'decimal')
						->addSelectValue( esc_attr( __('Square', 'ark' ) ), 'square')
						->addSelectValue( esc_attr( __('Lower Latin', 'ark' ) ), 'lower-latin')
						->addSelectValue( esc_attr( __('Lower Roman', 'ark' ) ), 'lower-roman')
						->addSelectValue( esc_attr( __('Upper Roman', 'ark' ) ), 'upper-roman')
						->addSelectValue( esc_attr( __('None', 'ark' ) ), 'none')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Marker Type', 'ark' ) ) )
					;

					$s->startHidingBox('type', array('icon') );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startAdvancedToggleBox('one-icon', esc_attr( __('Icon Marker', 'ark' ) ));
						
							$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-angle-right')
								->addParam('print-in-content', true)
							;

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Marker Color', 'ark' ) ) )
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Marker Background Color', 'ark' ) ) )
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-border-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Marker Border Color', 'ark' ) ) )
							;

						$s->endAdvancedToggleBox();

					$s->endHidingBox();

					$s->startHidingBox('type', array('disc', 'circle', 'decimal', 'square', 'lower-latin', 'lower-roman', 'upper-roman') );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'marker-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Marker Color', 'ark' ) ) )
						;

					$s->endHidingBox();

				$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

			$s->endRepVariationSection();

		$s->endRepVariableSection();

	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, params ) {

				if( query == null || !query.exists('list') ) {
				} else {
					query.get('list').each(function (query, variationType) {
						var text = query.getWithoutComparationDefault('one-text item-text', 'Lorem ipsum dolor sit amet');
						text = '&ndash; ' + text;
						query.addText(null, text);
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