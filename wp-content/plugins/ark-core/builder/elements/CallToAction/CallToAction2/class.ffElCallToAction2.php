<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_corporate_3.html#scrollTo__3800
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_creative.html#scrollTo__4420
 *
 */

class ffElCallToAction2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'call-to-action-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Call To Action 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'cta');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'call to action, sales');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE ICON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-thumbs-o-up')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', null)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-border-color', '', null)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Border Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE LABELS
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('labels', ark_wp_kses( __('Labels', 'ark' ) ) );

						$s->startRepVariableSection('content');

							/* TYPE TITLE */
							$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );

								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Great Performance')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;

								$s->startAdvancedToggleBox('telephone', esc_attr( __('Telephone', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'telephone-text', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
										->addParam('print-in-content', true)
									;
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'telephone-color', '', '[1]')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Telephone color', 'ark' ) ) )
									;
								$s->endAdvancedToggleBox();
							$s->endRepVariationSection();

							/* TYPE Description */
							$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Ark is the most amazing premium template with powerful customization settings.')
									->addParam('print-in-content', true)
								;
							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE BUTTON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

				// Do not delete, any Element needs to have at least one (hidden) option
				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="hidden">' );
					$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null, $useDot = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector, $useDot)
				->setAddWhiteSpaceBetweenSelectors(false)
				->addParamsString( $cssAttribute .': '. $query .';');
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="call-to-action-v2">';
			echo '<div class="center-content-hor-wrap-sm">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {
					case 'icon':
						ffElCallToAction2::_renderColor( $oneLine->getColor('icon-color'), 'color', '.theme-icons', false );
						ffElCallToAction2::_renderColor( $oneLine->getColor('icon-border-color'), 'border-color', '.theme-icons', false );
						echo '<div class="center-content-hor-align-sm">';
							echo '<div class="theme-icons-wrap">';
								$toPrint = '<i class="theme-icons theme-icons-dark-brd theme-icons-lg radius-circle '. $oneLine->getEscAttr('icon') .'"></i>';
								// Escaped icon
								echo ( $this->_applySystemThingsOnRepeatable( $toPrint, $oneLine ) );
							echo '</div>';
						echo '</div>';
						break;

					case 'labels':
						if( ! $oneLine->exists('content') ) {
							continue;
						}
						echo '<div class="center-content-hor-align-sm call-to-action-v2-labels">';

							foreach( $oneLine->get('content') as $oneItem ) {
								switch( $oneItem->getVariationType() ) {

									case 'title':
										echo '<h2 class="call-to-action-v2-title">'. $oneItem->getWpKses('text');

											$this->_advancedToggleBoxStart( $oneItem->get('telephone') );
												ffElCallToAction2::_renderColor( $oneItem->getColor('telephone telephone-color'), 'color', 'span', false );

												$phone = $oneItem->get('telephone telephone-text');
												if(! empty($phone)) {
													echo '&nbsp;<span class="call-to-action-v2-telephone">' . ark_wp_kses($phone) . '</span>';
												}
											$this->_advancedToggleBoxEnd( $oneItem->get('telephone') );

										echo '</h2>';
										break;

									case 'description':
										$oneItem->printWpKsesTextarea('text', '<p class="call-to-action-v2-text">', '</p>', '<div class="call-to-action-v2-text ff-richtext">', '</div>');
										break;

								}
							}

						echo '</div>';
						break;

					case 'button':
						
						echo '<div class="center-content-hor-align-sm text-right call-to-action-2-buttons">';
							$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneLine );
						echo '</div>';
						break;

				}
			}

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function(query, variationType ){
						switch(variationType){
							case 'icon':
								query.addIcon( 'icon' );
								break;

							case 'labels':
								query.get('content').each(function(query, variationType ){
									switch(variationType){

										case 'title':
											var text = query.get('text');
											text += ' ';
											var telephone = query.get('telephone telephone-text');
											query.addHeadingLg(null, text, telephone);
											break;

										case 'description':
											query.addText( 'text' );
											break;
									}
								});
								break;

							case 'button':
								blocks.render('button', query);
								break;

						}
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}