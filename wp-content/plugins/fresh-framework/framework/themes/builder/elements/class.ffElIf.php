<?php

class ffElIf extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'if');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'If');
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'grid, bootstrap, condition, php, if, else, endif');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_WRAPPER, false);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

	}

	public function getPreviewImageUrl() {
		return ffContainer()->getWPLayer()->getFrameworkUrl() . '/framework/themes/builder/elements/if.jpg';
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'General' );


			$s->addElement( ffOneElement::TYPE_NEW_LINE );
			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This element allows you to condition printing of its content by advanced if statements.');

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);


			/////////////////////////////////////////////////////////////////////////////////////
			// Center Content
			/////////////////////////////////////////////////////////////////////////////////////
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Condition' );
				$s->startSection('php');
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Write your PHP code here, do not forget the return statement.');
					$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT,'condition','','return true;')
						->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
					;

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Example: <code>return is_page("123"); // only prints the content, when you are on page with id "123"</code>');

					$s->addOption(ffOneOption::TYPE_SELECT, 'evaluation', '', 'weak')
						->addSelectValue('Weak', 'weak')
						->addSelectValue('Strong', 'strong')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ' Condition Evaluation Type')
						;
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Weak: <code> if ( $yourReturnedValue ) {} </code>');
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Strong: <code> if ( $yourReturnedValue === true ) {} </code>');
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'In strong evalutation, your condition is met only if you <code>return true;</code>. In weak evaluation, your condition is met, if you <code>return "some value";</code> as well, if its different from false.');

				$s->endSection();
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);


		$s->addElement( ffOneElement::TYPE_TABLE_END );



	}



	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$phpQuery = $query->get('php');

		$condition = $phpQuery->get('condition');
		$evaluation = $phpQuery->get('evaluation');


		$result = eval( $condition );
		if( $evaluation == 'weak' ) {

			if( $result ) {
				echo $this->_doShortcode( $content );
			}

		} else if( $evaluation == 'strong' ) {

			if( $result === true ) {
				echo $this->_doShortcode( $content );
			}

		}

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