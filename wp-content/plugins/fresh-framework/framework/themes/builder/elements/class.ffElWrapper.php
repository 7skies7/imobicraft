<?php

class ffElWrapper extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'grid, wrapper, div');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	public function getPreviewImageUrl() {
		return ffContainer()->getWPLayer()->getFrameworkUrl() . '/framework/themes/builder/elements/wrapper.jpg';
	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'HTML Tag');
				$s->addOption(ffOneOption::TYPE_TEXT,'html-attribute','','div');
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Caching');
				$s->addOption(ffOneOption::TYPE_CHECKBOX,'caching','Disable Caching of elements inside',0);
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'All elements are cached for better performance. Sometimes you need to disable this caching, so use this wrapper');
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
		$s->addElement(ffOneElement::TYPE_TABLE_END);

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$disableCaching = $query->getWithoutComparationDefault('caching', 0);

		if( $disableCaching ) {
			$this->_getStatusHolder()->addValueToCustomStack('disableCaching', true);
		}


		if( '' != $query->get('html-attribute') ) {

			echo '<'. $query->getEscAttr('html-attribute') .' class="fg-wrapper">';
				echo $this->_doShortcode( $content );
			echo '</'. $query->getEscAttr('html-attribute') .'>';

		} else {

			echo '<div class="fg-wrapper">';
				echo $this->_doShortcode( $content );
			echo '</div>';

		}

		if( $disableCaching ) {
			$this->_getStatusHolder()->removeValueFromCustomStack('disableCaching');
		}
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