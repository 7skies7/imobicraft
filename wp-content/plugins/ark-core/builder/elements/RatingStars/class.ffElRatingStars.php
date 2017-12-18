<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_star_ratings.html
 */

class ffElRatingStars extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'rating-stars');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Rating Stars', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'rating');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'rating, star, stars, percent, review, testimonial');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Overall Rating')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* STARS
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('rating', ark_wp_kses( __('Rating', 'ark' ) ));

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'current', '', '70')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('% Rating (0-100)', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'max', '', '5')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number of stars in total', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'empty-star-color', '', '#d9dfee')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Empty Star Color', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'star-color', '', '#ffc300')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Full Star Color', 'ark' ) ) )
						;

					$s->endRepVariationSection();

				$s->endRepVariableSection();

				// Do not delete, any Element needs to have at least one (hidden) option
				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="hidden">' );
					$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="star-rating">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'title':
						echo '<h2 class="star-rating-title">'. $oneLine->getWpKses('text') .'</h2>';
						break;

					case 'rating':
						echo '<div class="rating-container rating-sm rating-animate">';
							echo '<div class="rating">';

								$this->_renderCSSRule('color', $oneLine->getColor('empty-star-color'), ' .empty-stars', true );
								$this->_renderCSSRule('width', $oneLine->getEscAttr('current').'%', ' .filled-stars', true );
								$this->_renderCSSRule('color', $oneLine->getColor('star-color'), ' .filled-stars', true );

								echo '<span class="empty-stars">';
									for($i = 1; $i <= $oneLine->get('max'); $i++) {
										echo '<span class="star"><i class="glyphicon glyphicon-star-empty"></i></span>';
									}
								echo '</span>';

								echo '<span class="filled-stars">';
									for($i = 1; $i <= $oneLine->get('max'); $i++) {
										echo '<span class="star"><i class="glyphicon glyphicon-star"></i></span>';
									}
								echo '</span>';

							echo '</div>';
						echo '</div>';
						break;
				}
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $slement, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg( 'text' );
								break;
							case 'rating':
								query.addHeadingSm( 'current', '', '%');
								break;
						}
					});
				}
			
			}
		</script data-type="ffscript">
	<?php
	}


}