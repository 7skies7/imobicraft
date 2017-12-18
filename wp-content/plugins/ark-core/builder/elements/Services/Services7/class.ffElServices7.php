<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_services.html#scrollTo__5151
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_modern.html#scrollTo__450
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_classic.html#scrollTo__3762
 * @link http://demo.freshface.net/html/h-ark/HTML/index_corporate_1.html#scrollTo__788
 * @link http://demo.freshface.net/html/h-ark/HTML/index_boxed_bg_parallax_image.html#scrollTo__819
 */

class ffElServices7 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-7');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 7', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'services');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Ark Studio')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'description','', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.')
						->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE CLASSIC BTN
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('classic-button', ark_wp_kses( __('Button', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'button-title','', 'Read More')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text', 'ark' ) ))
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
						;
						
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-border-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Border Color', 'ark' ) ) )
						;
						
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) )
						;
						
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-hover-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Hover Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Box Height', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_TEXT,'icon-box-height','','')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom height of this icon box (in px)', 'ark' ) ) )
				;
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Default height is <code>450</code> px');

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute1, $cssAttribute2 , $selector = null, $whiteSpace = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors($whiteSpace)
				->addSelector($selector)
				->addParamsString( $cssAttribute1 .': '. $query .'; '. $cssAttribute2 .': '. $query .';');
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute1 .': '. $query .'; '. $cssAttribute2 .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="services-v7 services-v7-img-one">';
			echo '<div class="services-v7-body">';
				foreach( $query->get('content') as $oneLine ) {
					switch ($oneLine->getVariationType()) {

						case 'one-title':
							echo '<h2 class="services-v7-title">';
								$oneLine->printWpKses('title');
							echo '</h2>';
							break;

						case 'one-description':
							echo '<div class="services-v7-collapsed">';
								$oneLine->printWpKsesTextarea( 'description', '<p class="services-v7-text">', '</p>', '<div class="services-v7-text ff-richtext">', '</div>' );
							echo '</div>';
							break;

						case 'classic-button':
							ffElServices7::_renderColor( $oneLine->getColor('icon-color'), 'color', '', '.services-v7-link-icon', true );
							ffElServices7::_renderColor( $oneLine->getColor('icon-color'), 'background', '', '.services-v7-link-icon:before', true );
							ffElServices7::_renderColor( $oneLine->getColor('icon-color'), 'background', '', '.services-v7-link-icon:after', true );
							ffElServices7::_renderColor( $oneLine->getColor('icon-border-color'), 'border-color', '', '.services-v7-link-icon', true );
							ffElServices7::_renderColor( $oneLine->getColor('icon-hover-color'), 'background', '', '.services-v7-link-icon:hover:before', true );
							ffElServices7::_renderColor( $oneLine->getColor('icon-hover-color'), 'background', '', '.services-v7-link-icon:hover:after', true );
							ffElServices7::_renderColor( $oneLine->getColor('icon-bg-hover-color'), 'background', 'border-color', '.services-v7-link-icon:hover', true );

							echo '<div class="services-v7-more">';
								echo '<a ';
									$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'services-v7-link')->render( $oneLine );
								echo '>';
									echo '<i class="services-v7-link-icon radius-circle"></i>';
									echo '<span class="services-v7-link-title">';
										$oneLine->printWpKses('button-title');
									echo '</span>';
								echo '</a>';
							echo '</div>';

							break;

					}
				}
			echo '</div>';
		echo '</section>';

		$iconboxheight = $query->getWithoutComparationDefault('icon-box-height', null);

		if( $iconboxheight ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.services-v7.services-v7-img-one', false)
				->addParamsString('height: '.$iconboxheight.'px;');
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.services-v7.services-v7-img-one:hover', false)
				->addParamsString('height: '.$iconboxheight.'px;');
		}

	}



	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'one-title':
								query.addHeadingLg('title');
								break;
							case 'one-description':
								query.addText('description');
								break;
							case 'classic-button':
								blocks.render('button', query);
								break;
							case 'video-button':
							case 'gallery-button':
								query.addText('button-title');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}