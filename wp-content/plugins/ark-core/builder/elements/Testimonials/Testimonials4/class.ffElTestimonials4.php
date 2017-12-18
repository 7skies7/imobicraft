<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_testimonials.html#scrollTo__1937
 * */

class ffElTestimonials4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 4', 'ark' ) ) );
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
					$s->startRepVariationSection('one-subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Testimonials')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'What People say about Us')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('review', ark_wp_kses( __('Review', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Aliquam at nisi aliquam, elementum nulla et, luctus nulla. Praesent gravida facilisislectus, mattisinterdum enim ullamcorper sed. Curabitur rutrum lacinia augue, a ullamcorper urna ornare id. Vestibulum varius tellus eu finibus pretium')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE RATING
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('rating', ark_wp_kses( __('Rating', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-star');

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'count', '', '5')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number of stars (integer only)', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE AUTHOR
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('author', ark_wp_kses( __('Full Name', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Amy Clayton')
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
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', '(Manager)')
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

		echo '<section class="testimonials-v4 '. $query->getEscAttr('align') .'">';
			echo ' <div class="item">';

				foreach( $query->get('content') as $oneLine ) {
					switch( $oneLine->getVariationType() ) {

						case 'one-subtitle':
							echo '<span class="testimonials-v4-subtitle">'. $oneLine->getWpKses('text') .'</span>';
							break;

						case 'one-title':
							echo '<h3 class="testimonials-v4-title">'. $oneLine->getWpKses('text') .'</h3>';
							break;

						case 'review':
							echo '<h4 class="testimonials-v4-quote">'. $oneLine->getWpKses('text') .'</h4>';
							break;

						case 'rating':
							echo '<ul class="list-inline testimonials-v4-rating-list">';

								for ($i = 1; $i <= $oneLine->getWpKses('count'); $i++) {
									echo '<li><i class="font-size-13 '.$oneLine->getWpKses('icon').'"></i></li>';
								}

							echo '</ul>';
							break;

						case 'author':
							ffElTestimonials4::_renderColor( $oneLine->getColor('author-color'), 'color' );

							echo '<h4 class="testimonials-v4-author">'. $oneLine->getWpKses('text') .'</h4>';
							break;

						case 'occupation':
							echo '<span class="testimonials-v4-author-position">'. $oneLine->getWpKses('text') .'</span>';
							break;

					}
				}

			echo '</div>';
		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'one-subtitle':
								query.addHeadingSm('text');
								break;
							case 'one-title':
								query.addHeadingLg('text');
								break;
							case 'review':
								query.addText('text');
								break;
							case 'rating':
								query.addHeadingSm('count', '', ' Stars');
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