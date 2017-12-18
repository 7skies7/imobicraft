<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_modern.html#scrollTo__1744
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services.html#scrollTo__3726
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_services.html#scrollTo__3531
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_profile_2.html#scrollTo__2436
 *
 */

class ffElServices4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 4', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'services');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ));

				$s->startRepVariableSection('content');
					/*----------------------------------------------------------*/
					/* TYPE IMAGE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ));

						$s->addOptionNL(ffOneOption::TYPE_SELECT, 'icon-type', '', 'type-icon')
							->addSelectValue(esc_attr( __('Icon', 'ark' ) ), 'type-icon')
							->addSelectValue(esc_attr( __('Image', 'ark' ) ), 'type-image')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Type', 'ark' ) ) );
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startHidingBox('icon-type', array('type-image') );
								
							$this->_getBlock( ffThemeBlConst::IMAGE )
								->setParam('is-resize',true)
								->setParam('width', 70)
								->setParam('height', 70)
								->injectOptions( $s );

						$s->endHidingBox();

						$s->startHidingBox('icon-type', array('type-icon') );

							$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-camera');

						$s->endHidingBox();

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Notifications')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'description', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed.')
							->addParam('print-in-content', true)
						;

						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Having the Paragraph at exactly 2 lines of text on front-end will work best for proper alignment and spacing.', 'ark' ) ) );
					$s->endRepVariationSection();


					$s->startRepVariationSection('one-hover-description', ark_wp_kses( __('Extra Description', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'hover-description', '', 'More about Notifications')
							->addParam('print-in-content', true)
						;
						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Having the Extra Description at exactly 1 line of text on front-end will work best for proper alignment and spacing.', 'ark' ) ) );
					$s->endRepVariationSection();


				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', 'rgba(52,52,60,0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hover-color', '', '#eeeeee')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background Hover', 'ark' ) ) )
				;

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title Text', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'para-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Paragraph Text', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'para-hover-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Paragraph Text Hover', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'extra-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Extra Description Text', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


		 $s->addElement( ffOneElement::TYPE_TABLE_END );


	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$this->_renderCSSRule( 'background-color', $query->getColor( 'bg-color' ) );

		if( $query->getColor('hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.services-v4:hover:before')
				->addParamsString( 'background: '. $query->getColor('hover-color') .';');
		}

		$this->_renderCSSRule('color', $query->getColor('icon-color'), ' .services-v4-body .services-v4-icon-font', true );
		$this->_renderCSSRule('color', $query->getColor('icon-hover-color'), '.services-v4:hover .services-v4-body .services-v4-icon-font', true );
		$this->_renderCSSRule('color', $query->getColor('title-color'), ' .services-v4-body .services-v4-title', true );
		$this->_renderCSSRule('color', $query->getColor('para-color'), ' .services-v4-body .services-v4-text', true );
		$this->_renderCSSRule('color', $query->getColor('para-color'), ' .services-v4-body .services-v4-text p', true );
		$this->_renderCSSRule('color', $query->getColor('para-hover-color'), '.services-v4:hover .services-v4-body .services-v4-text', true );
		$this->_renderCSSRule('color', $query->getColor('para-hover-color'), '.services-v4:hover .services-v4-body .services-v4-text p', true );
		$this->_renderCSSRule('color', $query->getColor('extra-color'), ' .services-v4-body .services-v4-learn', true );
		$this->_renderCSSRule('color', $query->getColor('extra-color'), ' .services-v4-body .services-v4-learn p', true );

		echo '<section class="services-v4 '. $query->getEscAttr('content-align') .'">';
			echo '	<div class="center-content-hor-wrap-sm services-v4-body">';

				$isInContent = false;

				foreach( $query->get('content') as $oneLine ) {
					switch( $oneLine->getVariationType() ) {

						case 'one-title':
							if( !$isInContent ){ echo '<div class="center-content-hor-align-sm services-v4-content">'; $isInContent = true; }

							$toPrint = '<h3 class="services-v4-title">';
								$toPrint .= $oneLine->getWpKses('title');
							$toPrint .= '</h3>';
							$toPrint = $this->_applySystemThingsOnRepeatable( $toPrint, $oneLine );
							// Escaped title
							echo ( $toPrint );

							break;

						case 'one-description':
							if( !$isInContent ){ echo '<div class="center-content-hor-align-sm services-v4-content">'; $isInContent = true; }
							$toPrint = $oneLine->getWpKsesTextarea( 'description', '<p class="services-v4-text">', '</p>', '<div class="services-v4-text ff-richtext">', '</div>' );
							// escaped description
							echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneLine) );

							break;

						case 'one-hover-description':
							if( !$isInContent ){ echo '<div class="center-content-hor-align-sm services-v4-content">'; $isInContent = true; }

							$toPrint =  $oneLine->getWpKsesTextarea( 'hover-description', '<div class="services-v4-learn">', '</div>', '<div class="services-v4-learn ff-richtext">', '</div>' );
							// Escaped description
							echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneLine) );
							break;


						case 'icon':
							if( $isInContent ){ echo '</div>'; $isInContent = false; }

							echo '<div class="center-content-hor-align-sm services-v4-media">';

								if ( 'type-image' == $oneLine->get('icon-type') ){	

									$toPrint = $this->_getBlock( ffThemeBlConst::IMAGE )
												->setParam('width', 70)
												->setParam('height', 70)
												->setParam('css-class', 'services-v4-icon')
												->get( $oneLine );
									// Escaped image
									echo ( $this->_applySystemThingsOnRepeatable( $toPrint, $oneLine ) );
									
								} else if ( 'type-icon' == $oneLine->get('icon-type') ){

									echo '<i class="services-v4-icon-font '. $oneLine->getWpKses('icon') .'"></i>';
								}

							echo '</div>';

							break;
					}
				}

				if( $isInContent ){ echo '</div>'; }

			echo '</div>';

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
				$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam('classes', 'services-v4-link')->render($query);
				echo '></a>';
			}

		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'icon':
								if ( 'type-image' == query.get('icon-type') ){
									blocks.render('image', query);
								} else if ( 'type-icon' == query.get('icon-type') ){
									query.addIcon('icon');
								}
								break;
							case 'one-title':
								query.addHeadingLg('title');
								break;
							case 'one-description':
								query.addHeadingSm('description');
								break;
							case 'one-hover-description':
								query.addText('hover-description');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}