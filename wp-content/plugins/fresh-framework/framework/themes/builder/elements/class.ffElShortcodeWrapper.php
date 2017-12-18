<?php

class ffElShortcodeWrapper extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'shortcode-wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Shortcode Wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'shortcode container, wrapper, shortcode wrapper, wrapping, wraper, wraping, shortcodes, short code short-code');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_WRAPPER, false);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

	}

	public function getPreviewImageUrl() {
		return ffContainer()->getWPLayer()->getFrameworkUrl() . '/framework/themes/builder/elements/shortcode-wrapper.jpg';
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'General' );


		$s->addElement( ffOneElement::TYPE_NEW_LINE );
		$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This element allows you to wrap other Fresh Builder elements with custom shortcodes.');
		$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Equivalent of <code>[your_shortcode] Fresh Builder content here [/your_shortcode]');

		$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);


		/////////////////////////////////////////////////////////////////////////////////////
			// Center Content
			/////////////////////////////////////////////////////////////////////////////////////
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Shortcode' );
//				$s->startSection('php');
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Write your opening shortcode here');
					$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT,'shortcode-opening','','');
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Example: <code>[your_shortcode attribute_1="value"]</code>');

					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<strong>Here will be printed the content of this element</strong>');
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Write your closing shortcode here');
					$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT,'shortcode-closing','','');
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Example: <code>[/your_shortcode]</code>');

//				$s->endSection();
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );



	}



	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$openingShortcode = $query->get('shortcode-opening');
		$closingShortcode = $query->get('shortcode-closing');

		echo $openingShortcode;
		echo $this->_doShortcode( $content );
		echo $closingShortcode;
	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, elementModel, elementView ) {

			}
		</script data-type="ffscript">
		<?php
	}
}