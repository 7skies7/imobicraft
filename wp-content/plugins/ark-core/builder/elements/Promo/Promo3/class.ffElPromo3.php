<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_vertical_menu_creative.html#scrollTo__0
 * */


class ffElPromo3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'promo-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Promo 3', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'promo');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'promo, banner, hero');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Be Creative')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE SEPARATOR
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-subtitle', 'Subtitle' );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', '&')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Follow your Dreams')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE BUTTON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('buttons', ark_wp_kses( __('Buttons', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Align', 'ark' ) ));
				$s->addOption( ffOneOption::TYPE_SELECT, 'align', '', 'text-center')
					->addSelectValue(esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue(esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue(esc_attr( __('Right', 'ark' ) ), 'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="promo-block-v3 '.$query->getWpKses('align').'">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'one-title':
						echo '<h1 class="promo-block-v3-title">';
							$oneLine->printWpKses('text');
						echo '</h1>';

						break;

					case 'one-subtitle':
						echo '<p class="promo-block-v3-subtitle">';
							$oneLine->printWpKses('text');
						echo '</p>';

						break;

					case 'description':
						$oneLine->printWpKsesTextarea( 'text', '<p class="promo-block-v3-text">', '</p>', '<div class="promo-block-v3-text ff-richtext">', '</div>' );
						break;

					case 'buttons':
						echo '<div class="promo-block-v3-buttons-wrapper">';
							$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneLine );
						echo '</div>';

						break;
				}
			}

		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'one-title':
								query.addHeadingLg('text');
								break;
							case 'one-subtitle':
								query.addHeadingSm('text');
								break;
							case 'description':
								query.addText('text');
								break;
							case 'buttons':
								blocks.render('button', query);
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}