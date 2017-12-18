<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_creative.html
 */

class ffElAnimatedHeading2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'animated-heading-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Animated Heading 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'heading');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'heading, animated');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/* SUBTITLE */
					$s->startRepVariationSection('subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ));
						$s->addOptionNL(ffOneOption::TYPE_TEXT,'text','','A few we\'ve created for')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* ANIMATED LABELS */
					$s->startRepVariationSection('animated-labels', ark_wp_kses( __('Animated Text', 'ark' ) ));

						$s->addOptionNL(ffOneOption::TYPE_TEXT,'static-text','','')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Prefix (static)', 'ark' ) ) )
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startRepVariableSection('content');

							$s->startRepVariationSection('label', ark_wp_kses( __('One Animation', 'ark' ) ));
								$s->addOptionNL(ffOneOption::TYPE_TEXT, 'text', '', ark_wp_kses( __('Multifunctional Magic', 'ark' ) ) )
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

					/* PARAGRAPH */
					$s->startRepVariationSection('paragraph', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL(ffOneOption::TYPE_TEXTAREA,'text','','Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'align', 'text-center' );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', 'rgba(52,52,60,0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _renderColor( $query, $cssAttribute, $cssAfterAttribute = null, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .' '. $cssAfterAttribute .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _enqueueScriptsAndStyles( $query  ) {
		wp_enqueue_script( 'ark-animated-headline' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( ! $query->exists('content') ) {
			return;
		}

		$this->_renderCSSRule( 'background-color', $query->getColor( 'bg-color' ) );

		echo '<div class="animated-headline-v2 breadcrumbs-v5">';

			echo '<div class="animated-headline-v1 '
				. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'align', 'text-center' ) )
				. '">';


					foreach( $query->get('content') as $oneLine ) {
						switch( $oneLine->getVariationType() ) {

							case 'subtitle':
								echo '<p class="animated-headline-v1-subtitle">'. ark_wp_kses($oneLine->get('text')) .'</p>';
								break;

							case 'paragraph':
								$oneLine->printWpKsesTextarea('text', '<p class="breadcrumbs-v5-subtitle">', '</p>', '<div class="breadcrumbs-v5-subtitle ff-richtext">', '</div>');
								break;

							case 'animated-labels':

								echo '<h2 class="animated-headline-title letters type">';
									echo '<span class="animated-headline-prefix">';
										$oneLine->printWpKses('static-text');
									echo '</span>';

									if ( $oneLine->exists('content') ){
										echo '<span class="animated-headline-wrap waiting">';
										foreach( $oneLine->get('content') as $key => $oneLabel ) {

											if( 0 == $key ){
												echo '<b class="animated-headline-one-anim is-visible">'. $oneLabel->getWpKses('text') .'</b>';
											} else {
												echo '<b>'. $oneLabel->getWpKses('text') .'</b>';
											}

										}
									}

									echo '</span>';
								echo '</h2>';
								break;

						}
					}

			echo '</div>';
		echo '</div>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'subtitle':
								query.addHeadingSm('text');
								break;
							case 'paragraph':
								query.addHeadingSm('text');
								break;
							case 'animated-labels':
								query.get('content').each(function (query, variationType) {
									switch (variationType) {
										case 'label':
											query.addHeadingSm('text');
											break;
									}
								});

						}
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}