<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_classic.html#scrollTo__402
 */

class ffElProcess3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'process-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Process 3', 'ark' ) ) );
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

					$s->startRepVariationSection('image', ark_wp_kses( __('Image', 'ark' ) ) );

						$this->_getBlock( ffThemeBlConst::IMAGE )->setParam('width', 250)->setParam('height', 250)->injectOptions( $s );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Color', 'ark' ) ) );

					$s->endRepVariationSection();

					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', '01. Idea')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title', 'ark' ) ) )
						;

					$s->endRepVariationSection();


					$s->startRepVariationSection('paragraph', ark_wp_kses( __('Paragraph', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', 'Text', 'Lorem ipsum dolor sitamet consec, adipiscing elit. Sed sit amet blandit neque. Donec volutpat elit.');

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

	     $s->addElement( ffOneElement::TYPE_TABLE_END );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( $query->exists('content') ) {

			echo '<div class="process-v3">';

				foreach( $query->get('content') as $oneLine ) {
					switch( $oneLine->getVariationType() ) {
						case 'image':

							echo '<div>';
							$this->_getBlock( ffThemeBlConst::IMAGE)
								->setParam('width', 250)
								->setParam('height', 250)
								->setParam( ffBlImage::PARAM_CSS_CLASS, 'process-v3-element radius-circle')
								->render( $oneLine );
							echo '</div>';

							$borderColor = $oneLine->getColor('border-color');

							if( $borderColor ) {
								$this->_renderCSSRule('border', '5px solid ' . $borderColor, '.process-v3-element');
							}
							break;


						case 'title':
								echo '<h3 class="process-v3-title">';
									$oneLine->printWpKses( 'text' );
								echo '</h3>';
							break;

						case 'paragraph':
							$oneLine->printWpKsesTextarea( 'text', '<p class="process-v3-paragraph">', '</p>', '<div class="process-v3-paragraph ff-richtext">', '</div>' );
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
							case 'image':
								blocks.render('image', query);
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