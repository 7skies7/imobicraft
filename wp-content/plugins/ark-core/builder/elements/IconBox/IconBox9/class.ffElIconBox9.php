<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_classic.html#scrollTo__0
 */

class ffElIconBox9 extends ffThemeBuilderElementBasic {

	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'iconbox-9');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box 9', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'icon-box');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'icon, icon box');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE ITEM
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('item', ark_wp_kses( __('Item', 'ark' ) ) );

							$s->startRepVariableSection('content');

								/* TYPE ICON */
								$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-html5')
										->addParam('print-in-content', true);
								$s->endRepVariationSection();

								/* TYPE TITLE */
								$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'HTML')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

								$s->endRepVariationSection();

							$s->endRepVariableSection();

							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Boxes Align', 'ark' ) ) );

				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'content-align', 'text-center' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Boxes Settings', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'element-background', '', '#343434')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-background', '', 'rgba(255, 255, 255, 0.3)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-background-hover', '', 'rgba(255, 255, 255, 0.4)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Hover', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="promo-block-v11 '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'content-align', 'text-center' ) )
			. '">';
			echo '<ul class="list-inline promo-block-v11-category">';

				foreach( $query->get('content') as $oneItem ) {

					echo '<li class="promo-block-v11-category-item radius-3" ';
						$this->_getBlock( ffThemeBlConst::ANIMATION )->render( $oneItem );
					echo '>';

						echo '<a ';
						$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'promo-block-v11-category-link')->render( $oneItem );
						echo '>';

						foreach( $oneItem->get('content') as $oneItemContent ) {
							switch( $oneItemContent->getVariationType() ) {

								case 'icon':
									echo '<i class="promo-block-v11-category-icon '. $oneItemContent->getEscAttr('icon') .'"></i>';
									break;

								case 'title':
									echo '<div class="promo-block-v11-small-title">'. $oneItemContent->getEscAttr('text') .'</div>';
									break;

							}
						}

						echo '</a>';
					echo '</li>';

				}

			echo '</ul>';
		echo '</section>';

		$this->_renderCSSRule('background', $query->get('element-background'));
		$this->_renderCSSRule('background', $query->get('icon-background'), ' .promo-block-v11-category .promo-block-v11-category-item');
		$this->_renderCSSRule('background', $query->get('icon-background-hover'), ' .promo-block-v11-category .promo-block-v11-category-item:hover');

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {

							case 'item':
								query.get('content').each(function (query, variationType) {
									switch (variationType) {

										case 'icon':
											query.addIcon('icon');
											break;

										case 'title':
											query.addHeadingLg('text');
											break;

									}
								});
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}