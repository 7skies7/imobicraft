<?php

class ffElPostWrapper extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'post-wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Single Post Wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'loop');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, page, single, wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
		$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'HTML Tag');
		$s->addOption(ffOneOption::TYPE_TEXT,'html-attribute','','div');
		$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
		$s->addElement(ffOneElement::TYPE_TABLE_END);

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( have_posts() ){
			the_post();
		}
		$tag = 'div';

		if( '' != $query->get('html-attribute') ) {
			$tag  = $query->get('html-attribute');
		}

		echo '<'.$tag.' id="post-'; the_ID(); echo '" '; post_class('post-wrapper blog-grid-content');  echo '>';
		echo ( $this->_doShortcode( $content ) );
		echo '</'.$tag.'>';

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