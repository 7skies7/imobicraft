<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_newsletter.html#scrollTo__769
 * */


class ffElNewsletter1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'newsletter-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Newsletter 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'newsletter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'newsletter');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Input', 'ark' ) ) );
				$s->startAdvancedToggleBox('placeholder', esc_attr( __('Input Settings', 'ark' ) ));
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Email Address')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Placeholder text', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Input Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Placeholder text', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Subscribe Button', 'ark' ) ) );
				$s->startAdvancedToggleBox('button-text', esc_attr( __('Subscribe Button Settings', 'ark' ) ));
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'button-text', '', 'Subscribe')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );


	}

	protected function _placeholderColor($plColor, $bgColor, $borderColor){

		if($plColor) {
			$selectors = array('input::-webkit-input-placeholder', 'input:-moz-placeholder', 'input::-moz-placeholder', 'input:-ms-input-placeholder');

			foreach ($selectors as $sel) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector('.newsletter-v1 '.$sel, false)
					->addParamsString('color:' . $plColor .';');
			}
		}

		if($bgColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.newsletter-v1 .newsletter-v1-form')
				->addParamsString('background:' . $bgColor .';');
		}

		if($borderColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.newsletter-v1 .newsletter-v1-form')
				->addParamsString('border-color:' . $borderColor .';');
		}

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<section class="newsletter-v1">';
			echo '<div class="input-group">';

				$this->_advancedToggleBoxStart($query->get('placeholder'));
					$this->_placeholderColor($query->getColor('text-color'),$query->getColor('bg-color'),$query->getColor('border-color'));

					echo '<input type="text" class="form-control newsletter-v1-form radius-3" placeholder="'.$query->getWpKses('placeholder placeholder').'">';
				$this->_advancedToggleBoxEnd($query->get('placeholder'));

				echo '<span class="input-group-btn">';
					$this->_advancedToggleBoxStart($query->get('button-text'));
						echo '<button class="btn-dark-bg btn-base-md radius-3" type="button">'.$query->getWpKses('button-text button-text').'</button>';
					$this->_advancedToggleBoxEnd($query->get('button-text'));
				echo '</span>';

			echo '</div>';
		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				query.addText('placeholder placeholder');
				query.addLink('button-text button-text');

			}
		</script data-type="ffscript">
	<?php
	}


}