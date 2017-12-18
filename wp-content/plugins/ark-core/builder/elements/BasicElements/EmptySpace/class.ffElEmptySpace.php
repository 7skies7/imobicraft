<?php

/**
 * @link
 */

class ffElEmptySpace extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'emptySpace');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Empty Space', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'empty, space');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Height', 'ark' ) ) );
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Prints DIV element containing empty space. You can set it\'s height below.', 'ark' ) ) );
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addOption(ffOneOption::TYPE_TEXT,'height', '','100')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('px', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$this->getAssetsRenderer()->createCssRule()
			->addParamsString('height: '. $query->getEscAttr('height') . 'px;');

		echo '<div class="ffg-empty-space"></div>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {

				query.addHeadingSm( 'height', 'Empty Space (', 'px)' );

			}
		</script data-type="ffscript">
	<?php
	}


}