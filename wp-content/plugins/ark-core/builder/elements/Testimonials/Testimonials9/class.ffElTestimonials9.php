<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_business_1.html
 * */

class ffElTestimonials9 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials9');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 9', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'testimonials');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'testimonial, review');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );
				$s->startRepVariableSection('content');

					$s->startRepVariationSection('image', ark_wp_kses( __('Image', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()
							->setParam('width', 738)
							->injectOptions( $s );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);
							
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('xs'=>12,'md'=>'6'))->injectOptions( $s );
					$s->endRepVariationSection();

					$s->startRepVariationSection('review', ark_wp_kses( __('Review', 'ark' ) ) );

						$s->startRepVariableSection('review');

							/*----------------------------------------------------------*/
							/* TYPE ICON
							/*----------------------------------------------------------*/
							$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-star-o')
									->addParam('print-in-content', true)
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '[1]')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
								;
							$s->endRepVariationSection();

							/*----------------------------------------------------------*/
							/* TYPE SUBTITLE
							/*----------------------------------------------------------*/
							$s->startRepVariationSection('subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', '5 Stars')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'subtitle-color', '', '[1]')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Subtitle Color', 'ark' ) ) )
								;
							$s->endRepVariationSection();

							/*----------------------------------------------------------*/
							/* TYPE DESCRIPTION
							/*----------------------------------------------------------*/
							$s->startRepVariationSection('review', ark_wp_kses( __('Review', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', '"Ark makes your design last forever. It is a Smart Template for Creatives."')
									->addParam('print-in-content', true)
								;
							$s->endRepVariationSection();

							/*----------------------------------------------------------*/
							/* TYPE AUTHOR
							/*----------------------------------------------------------*/
							$s->startRepVariationSection('author', ark_wp_kses( __('Author', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'David Richy')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'author-color', '', '[1]')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Author Color', 'ark' ) ) )
								;
							$s->endRepVariationSection();

						$s->endRepVariableSection();
							
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
							
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('xs'=>12,'md'=>'6'))->injectOptions( $s );

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-center')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="testimonials-v9 op-b-testimonials '. $query->getEscAttr('align') .'">';
			echo '<div class="row">';
				foreach( $query->get('content') as $onePart ) {
					switch ($onePart->getVariationType()) {
						case 'review':
							echo '<div class="center-content-hor-align-md ' . $this->_getBlock(ffThemeBuilderBlock::BOOTSTRAP_COLUMNS)->render($onePart) . '">';
								foreach ($onePart->get('review') as $oneLine) {
									switch ($oneLine->getVariationType()) {

										case 'icon':
											ffElTestimonials9::_renderColor($oneLine->getColor('icon-color'),'color','op-b-testimonials-star');
											echo '<i class="op-b-testimonials-star ' . $oneLine->getWpKses('icon') . '"></i>';
											break;

										case 'subtitle':
											ffElTestimonials9::_renderColor($oneLine->getColor('subtitle-color'),'color','op-b-testimonials-star-no');
											echo '<span class="op-b-testimonials-star-no">';
											$oneLine->printWpKses('text');
											echo '</span>';
											break;

										case 'review':
											$oneLine->printWpKsesTextarea( 'text', '<p class="op-b-testimonials-quote">', '</p>', '<div class="op-b-testimonials-quote ff-richtext">', '</div>' );
											break;

										case 'author':
											ffElTestimonials9::_renderColor($oneLine->getColor('author-color'),'color','op-b-testimonials-author');
											echo '<h4 class="op-b-testimonials-author">';
											$oneLine->printWpKses('text');
											echo '</h4>';
											break;

									}
								}
							echo '</div>';
							break;
						case 'image':
							echo '<div class="center-content-hor-align-md ' . $this->_getBlock(ffThemeBuilderBlock::BOOTSTRAP_COLUMNS)->render($onePart) . '">';
								$this->_applySystemTabsOnRepeatableStart( $onePart );

									$this->_getBlock(ffThemeBlConst::IMAGE)
										->imgIsResponsive()
										->imgIsFullWidth()
										->setParam('width', 738)
										->setParam('css-class', 'testimonials-v9-user-picture')
								
										->render($onePart);
								$this->_applySystemTabsOnRepeatableEnd( $onePart );
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
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'review':
								query.get('review').each(function (query, variationType) {
									switch (variationType) {
										case 'icon':
											query.addIcon('icon');
											break;
										case 'subtitle':
											query.addHeadingSm('text');
											break;
										case 'review':
											query.addText('text');
											break;
										case 'author':
											query.addHeadingSm('text');
											break;
									}
								});
								break;
							case 'image':
								blocks.render('image', query);
								break;

						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}