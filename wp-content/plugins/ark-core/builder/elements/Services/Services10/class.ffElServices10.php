<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_services.html#scrollTo__397
 * @link http://demo.freshface.net/html/h-ark/HTML/index_business_4.html#scrollTo__410
 */

class ffElServices10 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-10');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 10', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'services');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE PREFIX
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-prefix', ark_wp_kses( __('Prefix', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'prefix', '', '01.')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Our Capabilities')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'description', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE BUTTON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Rhombus Separators', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-border-l', ark_wp_kses( __('Show Left Rhombus Separator', 'ark' ) ), 0);
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-border-r', ark_wp_kses( __('Show Right Rhombus Separator', 'ark' ) ), 0);

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '#ebeef6')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Line Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'rhombus-color', '', '#d3d3d3')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Rhombus Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'rhombus-in-border-color', '', '#f0f1f2')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Rhombus Inner Border Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'rhombus-out-border-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Rhombus Outer Border Color', 'ark' ) ) )
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

		$border_color_selectors = array(
			'.services-v10' => 'border-color',
			'.services-v10' => 'border-color',
			'.services-v10:before' => 'rhombus-in-border-color',
			'.services-v10:after' => 'rhombus-in-border-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-color:' . $color . ';');
			}
		}

		$background_color_selectors = array(
			'.services-v10:before' => 'rhombus-color',
			'.services-v10:after' => 'rhombus-color',
		);

		foreach( $background_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('background:' . $color . ';');
			}
		}

		$box_shadow_selectors = array(
			'.services-v10:before' => 'rhombus-out-border-color',
			'.services-v10:after' => 'rhombus-out-border-color',
		);

		foreach( $box_shadow_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('box-shadow: 0 0 0 4px ' . $color . ';');
			}
		}

		echo '<section class="services-v10 '.($query->get('show-border-l')? 'services-v10-border-l ':'').' '.($query->get('show-border-r')? 'services-v10-border-r ':'').' '. $query->getEscAttr('content-align') .'">';

			foreach( $query->get('content') as $oneLine ) {
				switch($oneLine->getVariationType()){

					case 'one-prefix':

						echo '<span class="services-v10-no">';
							$oneLine->printWpKses('prefix');
						echo '</span>';
						break;

					case 'one-title':

						echo '<h2 class="services-v10-title">';
							$oneLine->printWpKses('title');
						echo '</h2>';
						break;

					case 'one-description':
						$oneLine->printWpKsesTextarea( 'description', '<p class="services-v10-text">', '</p>', '<div class="services-v10-text ff-richtext">', '</div>' );
						break;

					case 'button':
						echo '<span>';
						$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneLine );
						echo '</span>';
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
							case 'one-prefix':
								query.addHeadingLg('prefix');
								break;
							case 'one-title':
								query.addHeadingSm('title');
								break;
							case 'one-description':
								query.addText('description');
								break;
							case 'button':
								blocks.render('button', query);
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}