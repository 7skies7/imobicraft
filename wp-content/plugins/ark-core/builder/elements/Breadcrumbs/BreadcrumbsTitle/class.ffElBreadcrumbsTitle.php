<?php

class ffElBreadcrumbsTitle extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'breadcrumbs-title');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Titlebar - Title Only', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'titlebar');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'breadcrumbs, titlebar, title, bar');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 1);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('HTML Tag', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_SELECT,'tag','','h1')
					->addSelectValue('H1','h1')
					->addSelectValue('H2','h2')
					->addSelectValue('H3','h3')
					->addSelectValue('H4','h4')
					->addSelectValue('H5','h5')
					->addSelectValue('H6','h6')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$this->_getBlock( ffThemeBlConst::PAGETITLE )->injectOptions( $s );

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$tag = $query->get('tag');
		echo '<'.$tag.' class="breadcrumbs-title">';
		$this->_getBlock( ffThemeBlConst::PAGETITLE )->render( $query );
		echo '</'.$tag.'>';
	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {
				query.addHeadingLg( null, 'Breadcrumbs Title' );
			}
		</script data-type="ffscript">
		<?php
	}


}