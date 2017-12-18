<?php

/**
 * @link
 */

class ffElSlide extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'slide');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Slide', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'slide');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_addParentWhitelistedElement('slider');
		$this->_addParentWhitelistedElement('custom-slider2');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Slide element does not have any options. Simply add any element(s) inside the Slide using the plus button in the builder.', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="hidden">');
					$s->addOption(ffOneOption::TYPE_TEXT,'blank','blank','');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<div class="item">';

			echo ( $this->_doShortcode( $content ) );

		echo '</div>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement, blocks ) {


			}
		</script data-type="ffscript">
	<?php
	}


}