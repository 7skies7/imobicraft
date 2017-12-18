<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_classic.html#scrollTo__0
 * */


class ffElPromo11 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'promo-11');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Promo 11', 'ark' ) ) );
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
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Discover the pixel perfect design')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title', 'ark' ) ) )
						;

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Find great PSD design, template & HTML/CSS themes from our talented experts.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE BUTTON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('buttons', ark_wp_kses( __('Buttons', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-center')
					->addSelectValue('Left', 'text-left')
					->addSelectValue('Center', 'text-center')
					->addSelectValue('Right', 'text-right')
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

		echo '<section class="promo-block-v11 '. $query->getWpKses('content-align') .'">';

			foreach( $query->get('content') as $oneItem ) {
				switch( $oneItem->getVariationType() ) {

					case 'title':
						echo '<h2 class="promo-block-v11-title">'. $oneItem->getWpKses('text') .'</h2>';
						break;

					case 'description':
						$oneItem->printWpKsesTextarea( 'text', '<p class="promo-block-v11-subtitle">', '</p>', '<div class="promo-block-v11-subtitle ff-richtext">', '</div>' );
						break;

					case 'buttons':
						echo '<div class="promo-block-v11-buttons-wrapper">';
							$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneItem );
						echo '</div>';
						break;
				}
			}

		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'description':
								query.addText('text');
								break;
							case 'buttons':
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