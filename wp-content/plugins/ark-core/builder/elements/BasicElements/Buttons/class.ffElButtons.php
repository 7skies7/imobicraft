<?php

/**
 * @link http://prothemes.net/ark/HTML/shortcodes_buttons.html
 */

class ffElButtons extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'buttons');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Buttons', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'button, link');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Buttons', 'ark' ) ) );

				$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Buttons Align', 'ark' ) ) );

				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'buttons-align', 'text-center' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<div class="buttons-el-wrapper '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'buttons-align', 'text-center' ) )
			. '">';

			$this->_getBlock(ffThemeBlConst::BUTTON)->render($query);

		echo '</div>';
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement, blocks ) {

				blocks.render('button', query);

			}
		</script data-type="ffscript">
	<?php
	}


}