<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_boxed_bg_pattern_image.html#scrollTo__1980
 */

class ffElCallToAction3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'call-to-action-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Call To Action 3', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'cta');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'call to action, sales');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/* TYPE TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Great Performance')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* TYPE Description */
					$s->startRepVariationSection('description', ark_wp_kses( __('Description', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Ark is the most amazing premium template with powerful customization settings and responsive design.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE BUTTONS
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('buttons', ark_wp_kses( __('Buttons Box', 'ark' ) ));

						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'items-alignment', 'text-center' );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}
		echo '<section class="call-to-action-v2 call-to-action-v2-3 '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'items-alignment', 'text-center' ) )
			. '">';
			echo '<div class="center-content-hor-wrap-sm">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'title':
						echo '<h2 class="call-to-action-v2-title">'. $oneLine->getWpKses('text') . '</h2>';
						break;

					case 'description':
						$oneLine->printWpKsesTextarea('text', '<p class="call-to-action-v2-text">', '</p>', '<div class="call-to-action-v2-text ff-richtext">', '</div>');
						break;

					case 'buttons':
						echo '<div>';
						$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('type', 'button')->render($oneLine);
						echo '</div>';
						break;

				}
			}

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'description':
								query.addText('text');
								break;
							case 'buttons':
								blocks.render('button', query);
								break;

						}
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}