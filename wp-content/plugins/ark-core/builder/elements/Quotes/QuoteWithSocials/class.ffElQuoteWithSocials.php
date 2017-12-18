<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_corporate_3.html#scrollTo__4100
 */

class ffElQuoteWithSocials extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'quote-with-socials');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Quote With Social Icons', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'quote');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'quote, social');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');

	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE QUOTE CHARACTER
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('quote-char', ark_wp_kses( __('Quote Character', 'ark' ) ));

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'q-char', '', '&ldquo;')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Quote Character', 'ark' ) ) )
						;

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE QUOTE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('quote', ark_wp_kses( __('Quote', 'ark' ) ));

						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.')
							->addParam('print-in-content', true)
						;

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE SOCIAL BOX
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('social-icons', ark_wp_kses( __('Social Icons', 'ark' ) ));
						$s->startRepVariableSection('social-icon');
							$s->startRepVariationSection('one-social-icon', ark_wp_kses( __('Social Icon', 'ark' ) ));
								$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-twitter')
									->addParam('print-in-content', true)
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#34343c')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon background color', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '#ffffff')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon color', 'ark' ) ) )
								;
								$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
							$s->endRepVariationSection( 'social-icon' );
						$s->endRepVariableSection();
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'alignment', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="quote-socials-v1 '. $query->getEscAttr('alignment') .'">';

			foreach( $query->get('content') as $oneItem ) {
				switch( $oneItem->getVariationType() ) {

					case 'quote-char':
						echo '<p class="quote-socials-v1-quote">'. $oneItem->get('q-char') .'</p>';

						break;

					case 'quote':
						$oneItem->printWpKsesTextarea( 'text', '<p class="quote-socials-v1-text">', '</p>', '<div class="quote-socials-v1-text ff-richtext">', '</div>' );
						break;

					case 'social-icons':

						echo '<ul class="list-inline ul-li-lr-2 quote-socials-v1-icons-list-wrapper">';

						foreach( $oneItem->get('social-icon') as $oneSocial ) {

							$color_selectors = array(
								' .animate-theme-icons-body' => 'color',
							);

							foreach( $color_selectors as $selector => $c ){
								$color = $oneSocial->getColor( $c );
								if( $color ) {
									$this->getAssetsRenderer()->createCssRule()
										->setAddWhiteSpaceBetweenSelectors(false)
										->addSelector($selector, false)
										->addParamsString('color:' . $color . ';');
								}
							}

							$bg_color_selectors = array(
								' .animate-theme-icons-body' => 'bg-color',
							);

							foreach( $bg_color_selectors as $selector => $c ){
								$color = $oneSocial->getColor( $c );
								if( $color ) {
									$this->getAssetsRenderer()->createCssRule()
										->setAddWhiteSpaceBetweenSelectors(false)
										->addSelector($selector, false)
										->addParamsString('background-color:' . $color . ';');
								}
							}

							echo '<li class="animate-theme-icons">';
								echo '<a ';
									// Escaped social link
									echo ( $this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'animate-theme-icons-body theme-icons-md radius-3')->get( $oneSocial ) );
								echo ' >';
									echo '<i class="animate-theme-icons-element '. $oneSocial->getEscAttr('icon') .'"></i>';
								echo '</a>';
							echo '</li>';
						}

						echo '</ul>';

						break;

				}
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'quote':
								query.addText('text');
								break;
							case 'social-icons':
								query.get('social-icon').each(function (query, variationType) {
									query.addIcon('icon');
								});
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}