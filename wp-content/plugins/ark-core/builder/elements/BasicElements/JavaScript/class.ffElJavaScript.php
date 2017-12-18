<?php

/**
 * @link
 */

class ffElJavaScript extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'javascript');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('JavaScript Code', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'js, javascript, script, code');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
		
		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, false );
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Code', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-wrapper ffb-options-textarea-code-el-js">' );

				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-js-start ffb-options-textarea-code-prefix"></div>' );

				$s->startHidingBox('type', 'jquery');
					$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-jquery-start ffb-options-textarea-code-prefix"></div>' );
				$s->endHidingBox();

					$s->addOption( ffOneOption::TYPE_TEXTAREA_STRICT, 'js', '', '')
					->addParam('rows', 30)
						->addParam( ffOneOption::PARAM_CODE_EDITOR, 'javascript')
					;
					;

				$s->startHidingBox('type', 'jquery');
					$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-jquery-end ffb-options-textarea-code-prefix"></div>' );
				$s->endHidingBox();

				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ffb-options-textarea-code-js-end ffb-options-textarea-code-prefix"></div>' );

				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Type', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type', '', 'js')
					->addSelectValue( esc_attr( __('JavaScript', 'ark' ) ), 'js')
					->addSelectValue( esc_attr( __('jQuery', 'ark' ) ), 'jquery')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		echo '<script type="text/javascript">';

			if ( 'jquery' == $query->get('type') ){
				echo '(function($) {';
			}
				$query->printText('js');

			if ( 'jquery' == $query->get('type') ){
				echo '})(jQuery);';
			}

		echo '</script>';
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {
				var jsText = query.get('js');

				if( 0 < jsText.length ) {
					query.addText(null, jsText);
				}

			}
		</script data-type="ffscript">
	<?php
	}


}