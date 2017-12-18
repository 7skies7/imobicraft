<?php
/**
 * @link http://prothemes.net/ark/HTML/shortcodes_work.html
 **/

class ffElGlobalStyle extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'globalStyle');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Global Style', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, false);
		$this->_setData( ffThemeBuilderElement::DATA_IS_HIDDEN, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, true);

	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('General', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_TEXT, 'name', 'Name ', '');

//				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('<strong>Static</strong> Header disappears after you scroll down.', 'ark' ) ) );
//				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('<strong>Fixed</strong> Header stays fixed to the top of the screen, whether you are scrolling or not.', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

//			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('General', 'ark')));

		$s->addElement( ffOneElement::TYPE_TABLE_END );
	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {


	}

	protected function _renderContentInfo_JS() {
		return;
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render( 'image', query );

				query.get('link').addText( 'button-title' );

				if(query.queryExists('content')) {
					query.get('content').get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'subtitle':
								query.addHeadingSm('category');
								query.addHeadingSm('date');
								break;
							case 'content':
								query.addText('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
		<?php
	}


}