<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_faq_modern.html#scrollTo__0
 */

class ffElFaq extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'faq');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box Link', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'icon-box');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'icon, icon box, faq');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE ICON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-chat')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE LABEL
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Support chat')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			/*----------------------------------------------------------*/
			/* TYPE BUTTON
			/*----------------------------------------------------------*/
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Button', 'ark' ) ) );
				$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Box Align', 'ark' ) ) );
				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'content-align', 'text-left' );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Box Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$bg_color_selectors = array(
			'.faq-v2' => 'bg-color',
		);

		foreach( $bg_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . ';');
			}
		}

		echo '<section class="faq-v2 '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'content-align', 'text-center' ) )
			. '">';

			echo '<div class="faq-v2-community radius-3">';

				if( $query->exists('content') ) {
					echo '<div class="faq-v2-community-content">';

						foreach( $query->get('content') as $oneLine ) {
							switch( $oneLine->getVariationType() ) {

								case 'icon':
									$this->getAssetsRenderer()->createCssRule()
										->addSelector('faq-v2-community-icon')
										->setAddWhiteSpaceBetweenSelectors(false)
										->addParamsString('color:'. $oneLine->getColor('icon-color').'');
									echo '<i class="faq-v2-community-icon '. $oneLine->getEscAttr('icon') .'"></i>';
									break;

								case 'title':
									echo '<h3 class="faq-v2-community-title">'. $oneLine->getWpKses('text') .'</h3>';
									break;

							}
						}

					echo '</div>';
				}

				echo '<div class="faq-v2-community-btn">';
					$this->_getBlock( ffThemeBlConst::BUTTON )->render( $query );
				echo '</div>';

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				query.get('content').each(function(query, variationType ){
					switch(variationType){
						case 'icon':
							query.addIcon( 'icon' );
							break;
						case 'title':
							query.addHeadingLg( 'text' );
							break;
					}
				});

				blocks.render('button', query);

			}
		</script data-type="ffscript">
	<?php
	}


}