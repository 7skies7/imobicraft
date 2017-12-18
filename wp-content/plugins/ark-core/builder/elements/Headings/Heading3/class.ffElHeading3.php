<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_headings.html#scrollTo__800
 */

class ffElHeading3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'heading-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Heading 3', 'ark' ) ) );
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
					$s->startRepVariationSection('header', ark_wp_kses( __('Heading', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Great Performance')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

					/* SEPARATOR */
					$s->startRepVariationSection('separator', ark_wp_kses( __('Divider', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-circle')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#d1d1d1')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Color', 'ark' ) ) );
						;
					$s->endRepVariationSection();

					/* TYPE PARAGRAPH */
					$s->startRepVariationSection('paragraph', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'It is the small details that will make a big difference')
							->addParam('print-in-content', true);

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

		echo '<section class="heading-v3 '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'text-alignment', 'text-center' ) )
			. '">';

			foreach( $query->get('repeated-lines') as $oneLine ) {
				switch ($oneLine->getVariationType()) {

					case 'header':
						$oneLine->printWpKsesTextarea(
							'text'
							, '<h2 class="heading-v3-title">'
							, '</h2>'
							, '<div class="heading-v3-title ff-richtext">'
							, '</div>'
						);
						break;

					case 'separator':

						$border_bottom_color_selectors = array(
							'.heading-v3-element:before' => 'divider-color',
							'.heading-v3-element:after' => 'divider-color',
						);

						foreach( $border_bottom_color_selectors as $selector => $c ){
							$color = $oneLine->getColor( $c );
							if( $color ) {
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector($selector, false)
									->addParamsString('border-bottom-color:' . $color . ';');
							}
						}

						echo '<p class="heading-v3-element"><i class="heading-v3-element-icon '. $oneLine->getEscAttr('icon') .'"></i></p>';
						break;

					case 'paragraph':
						$oneLine->printWpKsesTextarea(
							'text'
							, '<p class="heading-v3-text">'
							, '</p>'
							, '<div class="heading-v3-text ff-richtext">'
							, '</div>'
						);
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