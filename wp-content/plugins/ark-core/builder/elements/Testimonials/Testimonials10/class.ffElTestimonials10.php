<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/multiple-page/landing/index.html
 * */

class ffElTestimonials10 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials10');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 10', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'testimonials');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'testimonial, review');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE ICON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-facebook')
								->addParam('print-in-content', true)
							;
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#44619d')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
							;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE IMAGE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('image', ark_wp_kses( __('Image', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->setParam('width', 54)
							->setParam('height', 54)
							->injectOptions( $s );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'image-border-size', '', '3')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Size (in px)', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'image-border-color', '', '#ebeef6')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('review', ark_wp_kses( __('Review', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE LINK
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('link', ark_wp_kses( __('Link', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Robert Smith')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Text', 'ark' ) ) )
						;
						$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-hover-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link hover color', 'ark' ) ) )
						;
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


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-shadow', '', 'rgba(29,57,153,0.07)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Box Shadow', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $color, $selector ) {

		if( $color ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector($selector)
				->addParamsString('color: ' . $color .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		if( $query->getColor('el-bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-testimonials-v1', false)
				->addParamsString('background-color: '.$query->getColor('el-bg-color') . ';');
		}

		if( $query->getColor('el-shadow') ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-testimonials-v1', false)
				->addParamsString('box-shadow: 7px 7px 5px 0 '.$query->getColor('el-shadow') . ';');
		}

		echo '<section class="l-testimonials-v1 '. $query->getEscAttr('align') .'">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'image':
						
						if($oneLine->getColor('image-border-color') && $oneLine->get('image-border-size')){
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.l-testimonials-v1-user-picture',false)
								->addParamsString('border: '.$oneLine->get('image-border-size').'px solid '.$oneLine->getColor('image-border-color') . ';');
						}

						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->setParam('width', 54)
							->setParam('height', 54)
							->setParam('css-class', 'l-testimonials-v1-user-picture')
							->render( $oneLine );
						break;

					case 'icon':
						ffElTestimonials10::_renderColor( $oneLine->getColor('icon-color'), '.l-testimonials-v1-icon' );
						echo '<i class="l-testimonials-v1-icon ';
						$oneLine->printWpKses('icon');
						echo '"></i><br>';
						break;

					case 'review':
						$oneLine->printWpKsesTextarea( 'text', '<p class="l-testimonials-v1-quote">', '</p>', '<div class="l-testimonials-v1-quote ff-richtext">', '</div>' );
						break;

					case 'link':
						ffElTestimonials10::_renderColor( $oneLine->getColor('link-hover-color'), '.l-testimonials-v1-author:hover' );

						if( $oneLine->getColor('link-hover-color') ){
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.l-testimonials-v1-author:before', false)
								->addParamsString('background-color: '.$oneLine->getColor('link-hover-color') . ';');
						}

						echo '<a ';
						$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'l-testimonials-v1-author')->render( $oneLine );
						echo '>';
						$oneLine->printWpKses('text');
						echo '</a>';
						break;

				}
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
							case 'image':
								blocks.render('image', query);
								break;
							case 'icon':
								query.addIcon('icon');
								break;
							case 'review':
								query.addText('text');
								break;
							case 'link':
								query.addHeadingLg('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}