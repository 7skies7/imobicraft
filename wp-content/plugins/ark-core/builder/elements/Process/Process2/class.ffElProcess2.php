<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_classic.html#scrollTo__402
 */

class ffElProcess2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'process-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Process 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'process');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'process');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', 'Icon', 'ff-font-et-line icon-lightbulb');

					$s->endRepVariationSection();

					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Idea')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title', 'ark' ) ) )
						;

					$s->endRepVariationSection();


					$s->startRepVariationSection('paragraph', ark_wp_kses( __('Paragraph', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', 'Text', 'Lorem ipsum dolor sitamet consec, adipiscing elit. Sed sit amet blandit neque.');

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Color', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Color', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hover-color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Hover Color', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'background-color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'background-hover-color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover Color', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

	     $s->addElement( ffOneElement::TYPE_TABLE_END );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		/*----------------------------------------------------------*/
		/* COLORS
		/*----------------------------------------------------------*/
		$borderColor = $query->getColor('border-color');
		if( $borderColor ) {
			$this->_renderCSSRule('border', '8px solid ' . $borderColor,  '.process-v2-element');
		}

		$this->_renderCSSRule('color', $query->getColor('color'), '.process-v2-element' );
		$this->_renderCSSRule('color', $query->getColor('hover-color'), ':hover .process-v2-element', true );

		$this->_renderCSSRule('background', $query->getColor('background-color'), '.process-v2-element' );
		$this->_renderCSSRule('background', $query->getColor('background-hover-color'), ':hover .process-v2-element', true );


		if( $query->exists('content') ) {

			echo '<div class="process-v2">';

				foreach( $query->get('content') as $oneLine ) {
					switch( $oneLine->getVariationType() ) {
						case 'icon':
							echo '<span class="process-v2-element radius-circle">';
								echo '<i class="' . $oneLine->getEscAttr('icon') .'"></i>';
							echo '</span>';

							break;

						case 'title':
								echo '<h3 class="process-v2-title">';
									$oneLine->printWpKses( 'text' );
								echo '</h3>';
							break;

						case 'paragraph':
							$oneLine->printWpKsesTextarea( 'text', '<p class="process-v2-paragraph">', '</p>', '<div class="process-v2-paragraph ff-richtext">', '</div>' );
							break;
					}
				}

			echo '</div>';

		}

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if( query.exists('content') ) {
					query.get('content').each(function(query, variationType){
						switch (variationType) {
							case 'icon':
								query.addIcon('icon');
								break;

							case 'title':
								query.addHeadingLg('text');
								break;

							case 'paragraph':
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