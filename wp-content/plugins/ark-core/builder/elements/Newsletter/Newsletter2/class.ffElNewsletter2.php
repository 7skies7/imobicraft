<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_newsletter.html#scrollTo__769
 * @link http://demo.freshface.net/html/h-ark/HTML/index_boxed_bg_pattern_image.html#scrollTo__3695
 * */


class ffElNewsletter2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'newsletter-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Newsletter 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'newsletter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'newsletter');

		$this->_setColor('light');

	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Inputs', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/* TYPE SUBSCRIBE BOX */
					$s->startRepVariationSection('input', ark_wp_kses( __('Input', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Email Address')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Placeholder text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Placeholder text color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Subscribe Button', 'ark' ) ) );
				$s->startAdvancedToggleBox('button-text', esc_attr( __('Subscribe Button Settings', 'ark' ) ));
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'button-text', '', 'Subscribe')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Subscribe Button Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'btn-color', '', '#00bcd4')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'btn-hover-color', '', '#4ed7e8')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background hover ', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected  function  _placeholderColor($plColor, $bgColor, $borderColor){

		if($plColor) {
			$selectors = array('input::-webkit-input-placeholder', 'input:-moz-placeholder', 'input::-moz-placeholder', 'input:-ms-input-placeholder');

			foreach ($selectors as $sel) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(true)
					->addSelector($sel, false)
					->addParamsString('color:' . $plColor .';');
			}
		}

		if($bgColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.newsletter-v2-form')
				->addParamsString('background:' . $bgColor .';');
		}

		if($borderColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.newsletter-v2-form')
				->addParamsString('border: 1px solid ' . $borderColor .';');
		}

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $cssAfterAttribute = null, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .' '. $cssAfterAttribute .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<section class="newsletter-v2">';

			foreach( $query->get('content') as $oneLine ) {
				echo '<div class="ff-news-input">';

					$this->_placeholderColor($oneLine->getColor('text-color'),$oneLine->getColor('bg-color'),$oneLine->getColor('border-color'));
					echo '<input type="text" class="form-control newsletter-v2-form" placeholder="' . $oneLine->getWpKses('placeholder') . '">';

				echo '</div>';
			}

			$this->_advancedToggleBoxStart($query->get('button-text'));
				ffElNewsletter2::_renderColor( $query->getColor('btn-color'), 'background-color', null, '.btn-base-bg' );
				ffElNewsletter2::_renderColor( $query->getColor('btn-hover-color'), 'background-color', null, '.btn-base-bg:hover' );

				echo '<button class="btn-base-bg btn-base-md btn-block radius-3" type="button">'.$query->getWpKses('button-text button-text').'</button>';
			$this->_advancedToggleBoxEnd($query->get('button-text'));

		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				query.get('content').each(function(query, variationType){
					query.addText('placeholder');
				});
				query.addLink('button-text button-text');

			}
		</script data-type="ffscript">
	<?php
	}


}