<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_creative.html#scrollTo__4657
 * @link http://demo.freshface.net/html/h-ark/HTML/index_business_3.html#scrollTo__5326
 * @link http://demo.freshface.net/html/h-ark/HTML/index_business_2.html#scrollTo__5069
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_testimonials.html#scrollTo__1018
 * */

class ffElTestimonials3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 3', 'ark' ) ) );
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
					/* TYPE SUBTITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'sign', '', '&ldquo;')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Sign', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Google Inc.')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Multifunctional Magic')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('review', ark_wp_kses( __('Review', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Consectetur adipiscing elit. Curabitur ac ante pulvinar, malesuada mauris vel, vehicula sapien.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE IMAGE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('image', ark_wp_kses( __('Image', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->setParam('width', 50)
							->setParam('height', 50)
							->injectOptions( $s );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE AUTHOR
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('author', ark_wp_kses( __('Full Name', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Alex Nelson')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
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
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-shadow', '', 'rgba(0,0,0,0.07)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Box Shadow', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		if( $query->getColor('el-bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v3', false)
				->addParamsString('background-color: '.$query->getColor('el-bg-color') . ';');
		}

		if( $query->getColor('el-shadow') ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v3', false)
				->addParamsString('box-shadow: 0 2px 5px 3px '.$query->getColor('el-shadow') . ';');
		}

		echo '<section class="testimonials-v3 '. $query->getEscAttr('align') .'">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'subtitle':
						echo '<h6 class="testimonials-v3-subtitle">';
							echo '<span class="sign">';
								$oneLine->printWpKses('sign');
							echo '</span>';
							$oneLine->printWpKses('text');
						echo '</h6>';
						break;

					case 'title':
						echo '<h3 class="testimonials-v3-title">';
							$oneLine->printWpKses('text');
						echo '</h3>';
						break;

					case 'review':
						$oneLine->printWpKsesTextarea( 'text', '<p class="testimonials-v3-quote">', '</p>', '<div class="testimonials-v3-quote ff-richtext">', '</div>' );
						break;

					case 'image':
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->setParam('width', 50)
							->setParam('height', 50)
							->setParam('css-class', 'testimonials-v3-user-img')
							->render( $oneLine );
						break;

					case 'author':
						echo '<h4 class="testimonials-v3-author">';
							$oneLine->printWpKses('text');
						echo '</h4>';
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
							case 'subtitle':
								query.addHeadingLg('sign');
								query.addHeadingSm('text');
								break;
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'image':
								blocks.render('image', query);
								break;
							case 'review':
								query.addText('text');
								break;
							case 'author':
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