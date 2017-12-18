<?php

class ffElContainer extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'container');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Bootstrap Container');
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'grid');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'grid, bootstrap, container');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);


//		$this->_addDropzoneWhitelistedElement('row');
//		$this->_addParentWhitelistedElement('section-bootstrap');
	}

	public function getPreviewImageUrl() {
		return ffContainer()->getWPLayer()->getFrameworkUrl() . '/framework/themes/builder/elements/container.jpg';
	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Container');
				$s->addOptionNL(ffOneOption::TYPE_SELECT,'type','','fg-container-large')
					->addSelectValue('Small','fg-container-small')
					->addSelectValue('Medium','fg-container-medium')
					->addSelectValue('Large (default)','fg-container-large')
					->addSelectValue('Full Width','fg-container-fluid')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Container Size' )
				;
				$s->addOption(ffOneOption::TYPE_CHECKBOX,'no-padding','Remove horizontal padding from the Container',0);
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
		$s->addElement(ffOneElement::TYPE_TABLE_END);
	}

	private function _getContainerNestedLevel() {
		$elementStack = $this->_getStatusHolder()->getElementStackStatic();
		$elementsWithContainer = array('section', 'container');
		$level = 0;

		foreach( $elementStack as $oneItem ) {
			if( in_array( $oneItem, $elementsWithContainer ) ) {
				$level++;
			}
		}

		return $level;
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$container_classes = '';
		if( 'fg-container-fluid' == $query->get('type')){
			$container_classes = 'container-fluid fg-container-fluid';
		} else if( 'fg-container-large' == $query->get('type')){
			$container_classes = 'container fg-container-large';
		} else if( 'fg-container-medium' == $query->get('type')){
			$container_classes = 'container fg-container-medium';
		} else if( 'fg-container-small' == $query->get('type')){
			$container_classes = 'container fg-container-small';
		}

		$container_classes .= ' fg-container-lvl--' . $this->_getContainerNestedLevel();

		$gutter = '';
		if($query->get('no-padding')){
			$gutter = 'fg-container-no-padding';
		}
		
		echo '<div class="fg-container '.$container_classes.' '.$gutter.'">';
			echo $this->_doShortcode( $content );
		echo '</div>';


	}



		protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {


//                var content = query.get('select');

//                $elementPreview.html( 'sdsdsds' );


			}
		</script data-type="ffscript">
	<?php
	}

}