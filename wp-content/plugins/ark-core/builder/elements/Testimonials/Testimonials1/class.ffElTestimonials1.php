<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_corporate_2.html#scrollTo__6148
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_testimonials.html#scrollTo__397
 * */

class ffElTestimonials1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 1', 'ark' ) ) );
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
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'image-border-color', '', '#ebeef6')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('review', ark_wp_kses( __('Review', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ac ante pulvinar, malesuada mauris vel, vehicula sapien.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE AUTHOR
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('author', ark_wp_kses( __('Full Name', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Tina Krueger')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'author-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE OCCUPATION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('occupation', ark_wp_kses( __('Occupation', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Support')
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
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-shadow', '', '#b6c1de')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Box Shadow', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-box-bg', '', '#fdfdfd')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Box Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-box-inner-shadow', '', '#fdfdfe')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Box Inner Shadow', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
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

		if( $query->getColor('el-bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v1', false)
				->addParamsString('background-color: '.$query->getColor('el-bg-color') . ';');
		}

		if( $query->getColor('el-shadow') ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v1', false)
				->addParamsString('box-shadow: 0 4px 8px -3px '.$query->getColor('el-shadow') . ';');
		}

		if( $query->getColor('bg-box-bg') ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v1:before', false)
				->addParamsString('background-color: '.$query->getColor('bg-box-bg') . ';');
		}

		if( $query->getColor('bg-box-inner-shadow') ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v1:before', false)
				->addParamsString('box-shadow: inset 0 10px 10px 0 '.$query->getColor('bg-box-inner-shadow') . ';');
		}

		echo '<section class="testimonials-v1">';
			echo '<div class="testimonials-v1-body '. $query->getEscAttr('align') .'">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {
					case 'image':

						if( $oneLine->getColor('image-border-color') ){
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.testimonials-v1-user-picture', false)
								->addParamsString('border: '. $oneLine->getColor('image-border-size').'px solid '.$oneLine->getColor('image-border-color') . ';');
						}

						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->setParam('width', 54)
							->setParam('height', 54)
							->setParam('css-class', 'testimonials-v1-user-picture')
							->render( $oneLine );
						break;
					case 'review':
						$oneLine->printWpKsesTextarea( 'text', '<p class="testimonials-v1-quote">', '</p>', '<div class="testimonials-v1-quote ff-richtext">', '</div>' );
						break;
					case 'author':
						ffElTestimonials1::_renderColor( $oneLine->getColor('author-color'), 'color' );
						echo '<h4 class="testimonials-v1-author">';
							$oneLine->printWpKses('text');
						echo '</h4>';
						break;
					case 'occupation':
						echo '<span class="testimonials-v1-author-position">';
							$oneLine->printWpKses('text');
						echo '</span>';
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
							case 'image':
								blocks.render('image', query);
								break;
							case 'review':
								query.addText('text');
								break;
							case 'author':
								query.addHeadingLg('text');
								break;
							case 'occupation':
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