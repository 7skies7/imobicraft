<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_headings.html#scrollTo__1050
 */

class ffElHeading4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'heading-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Heading 4', 'ark' ) ) );
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

					/* SUB-TITLE */
					$s->startRepVariationSection('sub-title', ark_wp_kses( __('Sub Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'This template fits everywhere')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

					/* TYPE HEADING */
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Growth up your Business')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

					/* TYPE PARAGRAPH */
					$s->startRepVariationSection('paragraph', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Ark is the most amazing premium template with powerful customization <br/> settings and ultra fully responsive template.')
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

		echo '<section class="heading-v4 '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'text-alignment', 'text-center' ) )
			. '">';

			foreach( $query->get('repeated-lines') as $oneLine ) {
				switch ($oneLine->getVariationType()) {

					case 'title':
						$oneLine->printWpKsesTextarea(
							'text'
							, '<h2 class="heading-v4-title">'
							, '</h2>'
							, '<div class="heading-v4-title ff-richtext">'
							, '</div>'
						);
						break;

					case 'paragraph':
						echo '<div class="heading-v4-text">';

							$oneLine->printWpKsesTextarea(
								'text'
								, '<p>'
								, '</p>'
								, '<div class="ff-richtext">'
								, '</div>'
							);

						echo '</div>';

						break;

					case 'sub-title':
						$oneLine->printWpKsesTextarea(
							'text'
							, '<div class="heading-v4-subtitle">'
							, '</div>'
							, '<div class="heading-v4-subtitle ff-richtext">'
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
							case 'title':
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