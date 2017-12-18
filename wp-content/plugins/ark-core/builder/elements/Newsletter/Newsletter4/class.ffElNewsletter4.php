<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_landing_2.html#scrollTo__2022
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_newsletter.html#scrollTo__1787
 * */


class ffElNewsletter4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'newsletter-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Newsletter 4', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'newsletter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'newsletter');

		$this->_setColor('dark');

	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Labels', 'ark' ) ) );

				/*----------------------------------------------------------*/
				/* TYPE TITLE
				/*----------------------------------------------------------*/

				$s->startRepVariableSection('repeated-lines');

					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Keep in Touch with Us')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					$s->startRepVariationSection('one-subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Subscribe to our newsletter')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Input', 'ark' ) ) );
				/*----------------------------------------------------------*/
				/* TYPE SUBSCRIBE BOX
				/*----------------------------------------------------------*/
				$s->startAdvancedToggleBox('placeholder', esc_attr( __('Input Settings', 'ark' ) ) );
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
				$s->startAdvancedToggleBox('button-text', esc_attr( __('Subscribe Button Settings', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'button-text', '', 'Subscribe')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Subscribe Button Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-btn-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
				;
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
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector('.newsletter-v4 '.$sel, false)
					->addParamsString('color:' . $plColor .';');
			}
		}

		if($bgColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.newsletter-v4 .newsletter-v4-form')
				->addParamsString('background:' . $bgColor .' !important;');
		}

		if($borderColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.newsletter-v4 .newsletter-v4-form')
				->addParamsString('border-color:' . $borderColor .';');
		}


	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $cssAfterAttribute = null, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .' '. $cssAfterAttribute .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<section class="newsletter-v4">';
			echo '<div class="content">';
				echo '<div class="center-content-hor-wrap-sm">';

						echo '<div class="center-content-hor-align-sm center-content-hor-align-sm-width-sm newsletter-heading">';
							foreach( $query->get('repeated-lines') as $oneHeading ) {
								switch ($oneHeading->getVariationType()) {

									case 'one-title':
										echo '<h3 class="newsletter-v4-title">';
											$oneHeading->printWpKses('text');
										echo '</h3>';
										break;

									case 'one-subtitle':
										echo '<p class="newsletter-v4-text">';
											$oneHeading->printWpKses('text');
										echo '</p>';
										break;

								}
							}
						echo '</div>';

						echo '<div class="center-content-hor-align-sm">';
							echo '<div class="input-group">';

								$this->_advancedToggleBoxStart($query->get('placeholder'));
									$this->_placeholderColor($query->getColor('text-color'),$query->getColor('bg-color'),$query->getColor('border-color'));
									echo '<input type="text" class="form-control newsletter-v4-form" placeholder="' . $query->getWpKses('placeholder placeholder') . '">';
								$this->_advancedToggleBoxEnd($query->get('placeholder'));

								echo '<span class="input-group-btn">';
									ffElNewsletter4::_renderColor( $query->getColor('text-btn-color'), 'color', null, '.btn-base-bg' );
									ffElNewsletter4::_renderColor( $query->getColor('btn-color'), 'background-color', null, '.btn-base-bg' );
									ffElNewsletter4::_renderColor( $query->getColor('btn-hover-color'), 'background-color', null, '.btn-base-bg:hover' );

									$this->_advancedToggleBoxStart($query->get('button-text'));
										echo '<button class="btn-base-bg btn-base-md radius-3" type="button">'.$query->getWpKses('button-text button-text').'</button>';
									$this->_advancedToggleBoxEnd($query->get('button-text'));
								echo '</span>';

							echo '</div>';
						echo '</div>';

				echo '</div>';
			echo '</div>';
		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				query.get('repeated-lines').each(function(query, variationType){
					switch(variationType){
						case 'one-title':
							query.addHeadingLg('text');
							break;
						case 'one-subtitle':
							query.addHeadingSm('text');
							break;
					}
				});
				query.addText('placeholder placeholder', 'Input: ');
				query.addLink('button-text button-text');

			}
		</script data-type="ffscript">
	<?php
	}


}