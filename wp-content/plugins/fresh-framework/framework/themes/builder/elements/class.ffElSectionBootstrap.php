<?php

class ffElSectionBootstrap extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'section-bootstrap');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Bootstrap Section');
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'grid');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'grid, bootstrap, section');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

//		$this->_addDropzoneWhitelistedElement('container');

		$this->_addParentWhitelistedElement('canvas');
		$this->_addParentWhitelistedElement('if');
		$this->_addParentWhitelistedElement('shortcode-container');
	}

	public function getPreviewImageUrl() {
		return ffContainer()->getWPLayer()->getFrameworkUrl() . '/framework/themes/builder/elements/section-bootstrap.jpg';
	}


	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Info');
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '– <code>Bootstrap Section</code> allows you to use a flexible Bootstrap grid. It does not have any General options.');
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '– <strong>Correct nesting of the Bootstrap grid is as follows: <code>Section</code> > <code>Container</code> > <code>Row</code> > <code>Column</code></strong>');
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '– Do not nest <code>Container</code> into another <code>Container</code>.');
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '– <code>Row</code> should be placed within <code>Container</code> for proper alignment and padding.');
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '– Use <code>Row</code> to create horizontal groups of <code>Columns</code>.');
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '– Only <code>Column</code> may be immediate children of <code>Row</code>.');
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '– Any other content/elements should be usually placed within <code>Column</code> (exceptions allowed).');
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'More detailed information about the Bootstrap grid can be found here: <a target="_blank" href="http://getbootstrap.com/css/#grid">http://getbootstrap.com/css/#grid</a>');
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<strong>If you are a beginner and do not understand/want to use Bootstrap grid, then please use the simplified <code>Section</code> element instead.</strong>');
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				// Do not delete, any Element needs to have at least one (hidden) option
				$s->addElement( ffOneElement::TYPE_HTML, '', '<div style="display:none;">' );
					$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );
				
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
		$s->addElement(ffOneElement::TYPE_TABLE_END);

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<section class="fg-section" data-test="testik" id="xx" >';
			echo $this->_doShortcode( $content );
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

			}
		</script data-type="ffscript">
	<?php
	}

}