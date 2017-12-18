<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_me.html#scrollTo__2730
 */

class ffElCallToAction1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'call-to-action-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Call To Action 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'cta');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'call to action, sales');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/* TYPE TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'There is always time to talk call me at')
							->addParam('print-in-content', true)
						;

						$s->startAdvancedToggleBox('telephone', esc_attr( __('Telephone', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'telephone-text', '', '+123 456 7890')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								->addParam('print-in-content', true)
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'telephone-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Telephone color', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

					$s->endRepVariationSection();

					/* TYPE Description */
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'or')
							->addParam('print-in-content', true);

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE BUTTON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'align', 'text-center' );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Call To Action Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', 'rgba(0,0,0,0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null, $useDot = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector, $useDot)
				->addParamsString( $cssAttribute .': '. $query .';');
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		  }

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="call-to-action-v1 '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'align', 'text-left' ) )
			. '">';
		ffElCallToAction1::_renderColor( $query->getColor('bg-color'), 'background-color', '', false );

		foreach( $query->get('content') as $oneLine ) {
			switch( $oneLine->getVariationType() ) {

				case 'title':
					echo '<h2 class="call-to-action-v1-title">'. $oneLine->getWpKses('text') . '&nbsp;';

						$this->_advancedToggleBoxStart( $oneLine->get('telephone') );
							ffElCallToAction1::_renderColor( $oneLine->getColor('telephone telephone-color'), 'color', 'span', false );

							echo '<span class="call-to-action-v1-telephone">'. $oneLine->getWpKses('telephone telephone-text') .'</span>';
						$this->_advancedToggleBoxEnd( $oneLine->get('telephone') );

					echo '</h2>';
					break;

				case 'description':
					$toPrint = $oneLine->getWpKsesTextarea('text', '<p class="call-to-action-v1-text">', '</p>', '<div class="call-to-action-v1-text ff-richtext">', '</div>');
					$toPrint = $this->_applySystemThingsOnRepeatable( $toPrint, $oneLine );
					// Escaped user textarea
					echo ( $toPrint );
					break;

				case 'button':
					echo '<div>';
						$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneLine );
					echo '</div>';
					break;

			}
		}

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
								query.addHeadingSm('telephone telephone-text');
								break;

							case 'description':
								query.addText('text');
								break;

							case 'button':
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