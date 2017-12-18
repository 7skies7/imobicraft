<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_vertical_menu_one_page.html#scrollTo__0
 * @link http://demo.freshface.net/html/h-ark/HTML/features_header_section_scroll_right.html#scrollTo__540
 * @link http://demo.freshface.net/html/h-ark/HTML/features_header_section_scroll_left.html#scrollTo__0
 * */


class ffElPromo4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'promo-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Promo 4', 'ark' ) ));
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
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'ARK STUDIO')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
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

		echo '<section class="promo-block-v4 '.$query->getWpKses('align').'">';

			foreach( $query->get('content') as $oneLine ) {
				echo '<h2 class="promo-block-v4-title"';
				echo '>';
					$oneLine->printWpKses('text');
				echo '</h2>';
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, block, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query) {
						query.addHeadingLg('text');
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}