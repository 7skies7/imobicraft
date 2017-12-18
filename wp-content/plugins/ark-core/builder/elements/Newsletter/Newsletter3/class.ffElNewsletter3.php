<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_business_4.html#scrollTo__8976
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_newsletter.html#scrollTo__1435
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_teaser_right_sidebar.html#scrollTo__2264
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_teaser_left_sidebar.html#scrollTo__2264
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_right_sidebar.html#scrollTo__382
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_left_sidebar.html#scrollTo__382
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_fullwidth.html#scrollTo__382
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_both_sidebar.html#scrollTo__382
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_4_col.html#scrollTo__382
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_3_col.html#scrollTo__382
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_2_col.html#scrollTo__382
 * */


class ffElNewsletter3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'newsletter-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Newsletter 3', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'newsletter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'newsletter');

		$this->_setColor('dark');

	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Subscribe box', 'ark' ) ) );

				$s->startRepVariableSection('box');

					$s->startRepVariationSection('one-input', ark_wp_kses( __('Input', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Email')
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
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('xs'=>12, 'sm'=>4))->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Subscribe Button', 'ark' ) ) );
				$s->startAdvancedToggleBox('button', esc_attr( __('Subscribe Button Settings', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Subscribe')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Subscribe Button Grid', 'ark' ) ) );
				$s->startSection('box-bootstrap');
					$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('xs'=>12, 'sm'=>4))->injectOptions( $s );
				$s->endSection();
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
				->addSelector('.newsletter-v3-form')
				->addParamsString('background:' . $bgColor .';');
		}

		if($borderColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.newsletter-v3-form')
				->addParamsString('border: 1px solid ' . $borderColor .';');
		}

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<section class="newsletter-v3">';
			echo '<div class="row space-row-5">';

				if( $query->exists('box') ) {
					foreach( $query->get('box') as $oneInput ) {
						echo '<div class="'.$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->render( $oneInput ) .'">';
							$this->_applySystemTabsOnRepeatableStart($oneInput);
								echo '<div class="ff-news-input">';
									$this->_placeholderColor($oneInput->getColor('text-color'),$oneInput->getColor('bg-color'),$oneInput->getColor('border-color'));
									echo '<input type="text" class="form-control newsletter-v3-form radius-3" placeholder="' . $oneInput->getWpKses('placeholder') . '">';
								echo '</div>';
							$this->_applySystemTabsOnRepeatableEnd($oneInput);
						echo '</div>';
					}
				}

				echo '<div class="'.$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->render( $query->get('box-bootstrap') ) .'">';

					$this->_advancedToggleBoxStart($query->get('button'));
						echo '<button class="btn-dark-bg btn-base-md btn-block radius-3" type="button">'.$query->getWpKses('button text').'</button>';
					$this->_advancedToggleBoxEnd($query->get('button'));

				echo '</div>';

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('box')) {
					query.get('box').each(function (query, variationType) {
						query.addText('placeholder');
					});
				}
				query.addLink('button text');

			}
		</script data-type="ffscript">
	<?php
	}


}