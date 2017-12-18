<?php

/**
 * @link
 */

class ffElParagraph extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'paragraph');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Text', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'text, paragraph, tinymce, content');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_TEXTAREA,'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed cursus sapien, vitae fringilla sem. Duis convallis vel nunc at laoreet.')
				->addParam('print-in-content', true)
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text Alignment', 'ark' ) ) );
				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'align', 'text-center' );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	/**
	 * @param ffOptionsQueryDynamic $query
	 */
	protected function _checkIfElementCanBeCached( $query ) {
		$content = $query->get('o gen text');
		$containedShortcodes = $this->_getWPLayer()->findUsedShortcodes( $content );

		if( empty( $containedShortcodes ) ) {
			return true;
		} else {
			return false;
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$align = esc_attr( $this->_getGeneralTextAlignClasses( $query, 'align', 'text-center' ) );
		$paragraphContent = $query->getWpKsesTextarea(
			'text' ,
			'<p class="fg-paragraph ' . $align . '">' ,
			'</p>' ,
			'<div class="fg-paragraph ff-richtext ' . $align . '">' ,
			'</div>'
		);
		echo do_shortcode( $paragraphContent );
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {
				var text = query.get('text');

				if( text != null && 0 < text.length ) {
					query.addText(null, text);
				}
			}
		</script data-type="ffscript">
	<?php
	}


}