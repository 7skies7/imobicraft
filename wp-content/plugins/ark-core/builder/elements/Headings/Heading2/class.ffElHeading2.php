<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_headings.html#scrollTo__580
 */

class ffElHeading2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'heading-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Heading 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'heading');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'heading, subheading');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('repeated-lines');

					/* TYPE HEADING */
					$s->startRepVariationSection('header', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Welcome to Ark')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

					/* TYPE PARAGRAPH */
					$s->startRepVariationSection('paragraph', ark_wp_kses( __('Sub Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'We build the real value!')
							->addParam('print-in-content', true);
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#d1d1d1')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Color', 'ark' ) ) );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'text-alignment', 'text-center' );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('repeated-lines') ) {
			return;
		}

		echo '<section class="heading-v2 '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'text-alignment', 'text-center' ) )
			. '">';

			foreach( $query->get('repeated-lines') as $oneLine ) {
				switch ($oneLine->getVariationType()) {

					case 'header':
						$oneLine->printWpKsesTextarea(
							'text'
							, '<h2 class="heading-v2-title">'
							, '</h2>'
							, '<div class="heading-v2-title ff-richtext">'
							, '</div>'
						);
						break;

					case 'paragraph':

						$bg_color_selectors = array(
							'.heading-v2-text:before' => 'divider-color',
							'.heading-v2-text:after' => 'divider-color',
						);

						foreach( $bg_color_selectors as $selector => $c ){
							$color = $oneLine->getColor( $c );
							if( $color ) {
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector($selector, false)
									->addParamsString('background-color:' . $color . ';');
							}
						}

						echo '<div class="heading-v2-text">';

							$oneLine->printWpKsesTextarea(
								'text'
								, '<p>'
								, '</p>'
								, '<div class="ff-richtext">'
								, '</div>'
							);

						echo '</div>';

						break;

				}
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('repeated-lines')) {
					query.get('repeated-lines').each(function (query, variationType) {
						switch (variationType) {
							case 'header':
								query.addHeadingLg('text');
								break;
							case 'paragraph':
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