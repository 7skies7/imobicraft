<?php

class ffElLink extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'link');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Link Wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'link, anchor, hyperlink, href');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

	}

	public function getPreviewImageUrl() {
		return ffContainer()->getWPLayer()->getFrameworkUrl() . '/framework/themes/builder/elements/link.jpg';
	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Link Settings');
				$s->addElement( ffOneElement::TYPE_HTML, '', '<div style="display:none;">');
					$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank', 'blank');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>');

				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Display Mode');
				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'display-mode', '', 'block')
					->addSelectValue('block', 'block')
					->addSelectValue('inline-block', 'inline-block')
					->addSelectValue('inline', 'inline')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Horizontal padding (gutter) between Columns' )
				;			
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement(ffOneElement::TYPE_TABLE_END);

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$displayModeClass = $query->getWithoutComparationDefault('display-mode', 'block');
		$displayModeClass = 'display-'.$displayModeClass;

		echo '<a ';
			$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'fg-link fg-link-wrapper-el ' . $displayModeClass )->render( $query );
		echo '>';
			echo $this->_doShortcode( $content );
		echo '</a>';
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