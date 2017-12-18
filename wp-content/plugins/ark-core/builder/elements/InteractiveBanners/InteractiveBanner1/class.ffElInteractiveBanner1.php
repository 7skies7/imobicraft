<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_corporate_3.html#scrollTo__4100
 */

class ffElInteractiveBanner1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'interactive-banner-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Interactive Banner 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'interactive-banner');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'interactive banner, promo, hero, banner');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startAdvancedToggleBox('content', esc_attr( __('Content', 'ark' ) ) );

					$s->startRepVariableSection('personal-info');

						/*----------------------------------------------------------*/
						/* TYPE POSITION
						/*----------------------------------------------------------*/
						$s->startRepVariationSection('position', ark_wp_kses( __('Position', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Art Director')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
						$s->endRepVariationSection();

						/*----------------------------------------------------------*/
						/* TYPE NAME
						/*----------------------------------------------------------*/
						$s->startRepVariationSection('name', ark_wp_kses( __('Full Name', 'ark' ) ) );

							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Leyla Gomez')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

						$s->endRepVariationSection();

					$s->endRepVariableSection();

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Minimal Height', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'min-height', '', '500')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Minimal height of this element (in px)', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Background Image', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_IMAGE, 'img', ark_wp_kses( __('Background Image', 'ark' ) ), '');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'alignment', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content personal-info') ) {
			return;
		}

		$image = $query->getImage('img')->url;

		if( !empty( $image ) ) {
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString('background-image: url("' . $image . '");');
		}

		$minHeight = $query->get( 'min-height' );

		$this->getAssetsRenderer()->createCssRule()
			->addParamsString('min-height: ' . $minHeight . 'px;');

		echo '<section class="i-banner-v1 '. $query->getEscAttr('alignment') .'">';

			$this->_advancedToggleBoxStart( $query->get('content') );
				echo '<div class="i-banner-v1-heading">';

					foreach( $query->get('content personal-info') as $oneItem ) {
						switch( $oneItem->getVariationType() ) {

							case 'position':
								echo '<span class="i-banner-v1-member-position">'. $oneItem->getWpKses('text') .'</span>';
								break;

							case 'name':
								echo '<h4 class="i-banner-v1-member">'. $oneItem->getWpKses('text') .'</h4>';
								break;

						}
					}

				echo '</div>';

			$this->_advancedToggleBoxEnd( $query->get('content') );

		echo '</section>';
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementInfo, $element, blocks, preview, view ) {

				if(query.queryExists('content personal-info')) {
					if (query.getWithoutComparationDefault('img', null) != '') {
						query.addImage('img');
					}

					query.get('content').get('personal-info').each(function (query, variationType) {
						switch (variationType) {
							case 'position':
								query.addText('text');
								break;
							case 'name':
								query.addHeadingLg('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}