<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_classic.html#scrollTo__3054
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_modern.html#scrollTo__1890
 * */

class ffElTestimonials2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 2', 'ark' ) ) );
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

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Built on the principles of excellence')
							->addParam('print-in-content', true)
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
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Alex Nelson')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon', 'ark' ) ) );

				$s->startAdvancedToggleBox('icon', esc_attr( __('Icon', 'ark' ) ) );
					$s->addOptionNL(ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-gears');
					$s->addOption(ffOneOption::TYPE_SELECT, 'icon-align', '', 'icon-right')
						->addSelectValue('Left','icon-left')
						->addSelectValue('Right','icon-right')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Position', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'stop-icon-overflow',ark_wp_kses( __('Prevent the icon from overflowing outside of the element boundaries', 'ark' ) ),0);
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', 'rgba(255,255,255,0.2)')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-left')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', 'rgba(52,52,60,0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) )
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

		if( '1' == $query->getColor('icon stop-icon-overflow') ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v2', false)
				->addParamsString('overflow: hidden;');
		}

		$this->_renderCSSRule( 'background-color', $query->getColor( 'bg-color' ) );

		echo '<section class="testimonials-v2 '. $query->getEscAttr('align') .'">';

			ffElTestimonials2::_renderColor( $query->getColor('icon icon-color'), 'color', '.testimonials-v2-icon' );

			$this->_advancedToggleBoxStart( $query->get('icon') );

				echo '<span class="testimonials-v2-icon '.$query->get('icon icon').' '.$query->get('icon icon-align').'"></span>';

			$this->_advancedToggleBoxEnd( $query->get('icon') );

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'title':
						echo '<h3 class="testimonials-v2-title">';
							$oneLine->printWpKses('text');
						echo '</h3>';
						break;

					case 'review':
						$oneLine->printWpKsesTextarea( 'text', '<p class="testimonials-v2-quote">', '</p>', '<div class="testimonials-v2-quote ff-richtext">', '</div>' );
						break;

					case 'author':
						echo '<span class="testimonials-v2-author">';
							$oneLine->printWpKses('text');
						echo '</span>';
						break;

				}
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

				query.addIcon('icon icon');

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'review':
								query.addText('text');
								break;
							case 'author':
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