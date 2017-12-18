<?php

/**
 * @link
 */

class ffElList extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'list');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('List', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'text, list');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$this->_getBlock( ffThemeBlConst::LISTBASIC )->injectOptions( $s );

				// Do not delete, any Element needs to have at least one (hidden) option
				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="hidden">' );
					$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$this->_getBlock(ffThemeBlConst::LISTBASIC)->render($query);
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement, blocks ) {
				blocks.render('list', query);
			}
		</script data-type="ffscript">
	<?php
	}


}