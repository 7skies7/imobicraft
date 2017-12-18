<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/premium/rev-slider/carousel-highlight.html#scrollTo__810
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_tab.html#scrollTo__763
 */

class ffElHeading1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'heading-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Heading 1', 'ark' ) ) );
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
					$s->startRepVariationSection('header', ark_wp_kses( __('Heading', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Premium Slider Revolution')
							->addParam('print-in-content', true);

						$s->addOption( ffOneOption::TYPE_SELECT, 'style', '', 'heading-v1-title')
							->addSelectValue( esc_attr( __('Bold & Cursive', 'ark' ) ), 'heading-v1-title')
							->addSelectValue( esc_attr( __('Normal', 'ark' ) ), 'heading-v1-Section')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Style', 'ark' ) ) );
					$s->endRepVariationSection();

					/* TYPE PARAGRAPH */
					$s->startRepVariationSection('paragraph', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'To help you design even faster, there is a growing array of beautiful premium Slider Revolution templates integrated into Ark. All example sliders you find below are included.')
							->addParam('print-in-content', true);

						$s->addOption( ffOneOption::TYPE_SELECT, 'style', '', 'heading-v1-text')
							->addSelectValue( esc_attr( __('Biggest (18px) & Cursive', 'ark' ) ), 'heading-v1-text')
							->addSelectValue( esc_attr( __('Bigger (16px) & Cursive', 'ark' ) ), 'heading-v1-bigger-text')
							->addSelectValue( esc_attr( __('Normal (15px)', 'ark' ) ), '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Style', 'ark' ) ) );
					$s->endRepVariationSection();

					/* SUB-TITLE */
					$s->startRepVariationSection('sub-title', ark_wp_kses( __('Sub Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'We are the founders of Ark')
							->addParam('print-in-content', true);
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'subtitle-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Subtitle color', 'ark' ) ) )
						;
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

		echo '<section class="heading-v1 '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'text-alignment', 'text-center' ) )
			. '">';

			foreach( $query->get('repeated-lines') as $oneLine ) {
				switch ($oneLine->getVariationType()) {

					case 'header':
						$oneLine->printWpKsesTextarea(
							'text'
							, '<h2 class="'. $oneLine->getEscAttr('style') .'">'
							, '</h2>'
							, '<div class="'. $oneLine->getEscAttr('style') .' ff-richtext">'
							, '</div>'
						);
						break;

					case 'paragraph':
						$oneLine->printWpKsesTextarea(
							'text'
							, '<p class="heading-v1-text-content '. $oneLine->getEscAttr('style') .'">'
							, '</p>'
							, '<div class="heading-v1-text-content '. $oneLine->getEscAttr('style') .' ff-richtext">'
							, '</div>'
						);
						break;

					case 'sub-title':
						$this->_renderCSSRule('color', $oneLine->getColor('subtitle-color'));
						$this->_renderCSSRule('color', $oneLine->getColor('subtitle-color'), 'p');
						$oneLine->printWpKsesTextarea(
							'text'
							, '<p class="heading-v1-subtitle">'
							, '</p>'
							, '<div class="heading-v1-subtitle ff-richtext">'
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
							case 'sub-title':
								query.addHeadingSm('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}