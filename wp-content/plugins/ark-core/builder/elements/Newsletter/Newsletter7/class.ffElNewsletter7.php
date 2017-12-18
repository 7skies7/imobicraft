<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_landing_2.html#scrollTo__2022
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_newsletter.html#scrollTo__1787
 * */


class ffElNewsletter7 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'newsletter-7');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Newsletter 7', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'newsletter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'newsletter');

		$this->_setColor('dark');

	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Title', 'ark' ) ) );
				$s->startAdvancedToggleBox('title', esc_attr( __('Title Settings', 'ark' ) ));
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Get the latest news')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


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


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Button', 'ark' ) ) );

				$s->startAdvancedToggleBox('button', esc_attr( __('Button Settings', 'ark' ) ));
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Subscribe')
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
					->addSelector('.newsletter-v7 '.$sel, false)
					->addParamsString('color:' . $plColor .';');
			}
		}

		if($bgColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.newsletter-v7 .newsletter-v7-form')
				->addParamsString('background:' . $bgColor .';');
		}

		if($borderColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.newsletter-v7 .newsletter-v7-form')
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

		echo '<section class="newsletter-v7">';
			echo '<div class="content">';
				echo '<div class="center-content-hor-wrap-sm">';

					echo '<div class="center-content-hor-align-sm center-content-hor-align-sm-width-sm newsletter-heading sm-margin-b-20">';

						$this->_advancedToggleBoxStart($query->get('title'));
							echo '<h3 class="newsletter-v7-title">'. $query->getWpKses('title text') .'</h3>';
						$this->_advancedToggleBoxEnd($query->get('title'));

					echo '</div>';

					echo '<div class="center-content-hor-align-sm">';
						echo '<div class="input-group">';

							$this->_advancedToggleBoxStart($query->get('placeholder'));
								$this->_placeholderColor($query->getColor('text-color'),$query->getColor('bg-color'),$query->getColor('border-color'));

								echo '<input type="text" class="form-control newsletter-v7-form" placeholder="' . $query->getWpKses('placeholder placeholder') . '">';
							$this->_advancedToggleBoxEnd($query->get('placeholder'));

							echo '<span class="input-group-btn">';
								ffElNewsletter7::_renderColor( $query->getColor('text-btn-color'), 'color', null, '.btn-base-bg' );
								ffElNewsletter7::_renderColor( $query->getColor('btn-color'), 'background-color', null, '.btn-base-bg' );
								ffElNewsletter7::_renderColor( $query->getColor('btn-hover-color'), 'background-color', null, '.btn-base-bg:hover' );

								$this->_advancedToggleBoxStart($query->get('button'));
									echo '<button class="btn-base-bg btn-base-sm newsletter-v7-btn" type="button">'.$query->getWpKses('button text').'</button>';
								$this->_advancedToggleBoxEnd($query->get('button'));
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

				query.addHeadingLg('title text');
				query.addText('placeholder placeholder', 'Input: ');
				query.addLink('button text');

			}
		</script data-type="ffscript">
	<?php
	}


}