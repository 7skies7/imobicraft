<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_classic.html#scrollTo__402
 */

class ffElProcess extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'process');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Process', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'process');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'process');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startAdvancedToggleBox('foreground', esc_attr( __('Front Side', 'ark' ) ));

					$s->startRepVariableSection('foreground-items');

						/* TYPE TITLE */
						$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));

							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Idea.')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title', 'ark' ) ) )
							;

						$s->endRepVariationSection();

					$s->endRepVariableSection();

				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox('overlay', esc_attr( __('Back Side', 'ark' ) ));
	
					$s->startRepVariableSection('overlay-items');

						/* TYPE TITLE */
						$s->startRepVariationSection('paragraph', ark_wp_kses( __('Paragraph', 'ark' ) ));
			
							$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consec tetur adipisicing elitseddo eiusmod.')
									->addParam('print-in-content', true);

						$s->endRepVariationSection();

					$s->endRepVariableSection();

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Background', 'ark' ) ) );
					$s->addOptionNL(ffOneOption::TYPE_IMAGE,'img', ark_wp_kses( __('Front Side - Background Image', 'ark' ) ),'');

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'back-side-bg-color', '' , '[1]')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Back Side - Background Color', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Link', 'ark' ) ) );

				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$img = $query->getImage('img')->url;

		if( !empty($img) ) {
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString('background-image: url(' . $img . ');');

			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.process-v1-front')
				->addParamsString('background-image: url("' . $img . '");');
		}

		$background_color_selectors = array(
			' .process-v1-back' => 'back-side-bg-color',
		);

		foreach( $background_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . ';');
			}
		}

		echo '<section class="process-v1">';

			echo '<div class="process-v1-body">';

				echo '<div class="process-v1-flip">';

					if( $query->exists('foreground foreground-items') ) {
						$this->_advancedToggleBoxStart( $query->get('foreground') );
							echo '<div class="process-v1-front">';
								echo '<div class="process-v1-center-align">';

									foreach( $query->get('foreground foreground-items') as $oneItem ) {
										switch( $oneItem->getVariationType() ) {

											case 'title':
												echo '<h4 class="process-v1-title">';
													$oneItem->printWpKses('text');
												echo '</h4>';
												break;

										}
									}

								echo '</div>';
							echo '</div>';
						$this->_advancedToggleBoxEnd( $query->get('foreground') );
					}

					if( $query->exists('overlay overlay-items') ) {
						$this->_advancedToggleBoxStart( $query->get('overlay') );

							echo '<div class="process-v1-back">';
								echo '<div class="process-v1-center-align">';
									foreach( $query->get('overlay overlay-items') as $oneItem ) {
										switch( $oneItem->getVariationType() ) {

											case 'paragraph':
												$oneItem->printWpKsesTextarea( 'text', '<p class="process-v1-text">', '</p>', '<div class="process-v1-text ff-richtext">', '</div>' );
												break;

										}
									}
								echo '</div>';
							echo '</div>';
						$this->_advancedToggleBoxEnd( $query->get('overlay') );
					}

				echo '</div>';

				echo '<a ';
					$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'process-v1-link')->render( $query );
				echo '></a>';

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.getWithoutComparationDefault('img', null) != '') {
					query.addImage('img');
				}

				if(query.queryExists('foreground foreground-items')) {
					query.get('foreground').get('foreground-items').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;

						}
					});
				}

				if(query.queryExists('overlay overlay-items')) {
					query.get('overlay').get('overlay-items').each(function (query, variationType) {
						switch (variationType) {
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