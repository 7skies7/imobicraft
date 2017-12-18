<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_boxed_bg_parallax_image.html#scrollTo__3235
 */

class ffElInteractiveBanner3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'interactive-banner-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Interactive Banner 3', 'ark' ) ) );
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

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE SUB-TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('sub-title', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Ark Studio')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'subtitle-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Subtitle color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE NAME
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'It is the time to bring out the basics and let Ark do all the talking and working')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ipsum mi, rhoncus a suscipit in, finibus vel leo. Suspendisse potenti. Morbi vestibulum, lectus ut viverra congue.')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Minimal Height', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'min-height', '', '600')
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
		if( ! $query->exists('content') ) {
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

		echo '<section class="i-banner-v3 '. $query->getEscAttr('alignment') .'">';


			echo '<div class="i-banner-v3-wrap">';
				echo '<div class="container">';
					echo '<div class="i-banner-v3-content">';

						foreach( $query->get('content') as $oneItem ) {
							switch( $oneItem->getVariationType() ) {

								case 'sub-title':
									$color = $oneItem->getColor('subtitle-color');
									if( !empty($color) ) {
										$this->getAssetsRenderer()->createCssRule()
											->addSelector('i-banner-v3-subtitle')
											->setAddWhiteSpaceBetweenSelectors(false)
											->addParamsString('color:' . $color . '');
									}
									echo '<span class="i-banner-v3-subtitle">'. $oneItem->getWpKses('text') .'</span>';
									break;

								case 'title':
									$oneItem->printWpKsesTextarea( 'text', '<h2 class="i-banner-v3-title">', '</h2>', '<div class="i-banner-v3-title ff-richtext">', '</div>' );
									break;

								case 'description':
									$oneItem->printWpKsesTextarea( 'text', '<p class="i-banner-v3-text">', '</p>', '<div class="i-banner-v3-text ff-richtext">', '</div>' );
									break;

							}
						}

					echo '</div>';
				echo '</div>';
			echo '</div>';

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					if (query.getWithoutComparationDefault('img', null) != '') {
						query.addImage('img');
					}

					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'sub-title':
								query.addHeadingSm('text');
								break;
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'description':
								query.addText('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}