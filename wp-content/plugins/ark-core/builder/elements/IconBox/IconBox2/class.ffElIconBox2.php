<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us.html#scrollTo__800
 */

class ffElIconBox2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'iconbox-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'icon-box');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'icon, icon box');

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
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-wine')
							->addParam('print-in-content', true);
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE LABELS
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('labels', ark_wp_kses( __('Text Area', 'ark' ) ));

						$s->startRepVariableSection('repeated-lines');

							/* SUB-TITLE */
							$s->startRepVariationSection('sub-title', ark_wp_kses( __('Sub Title', 'ark' ) ));
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Best style and design')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
							$s->endRepVariationSection();

							/* TITLE */
							$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Stunning design')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
							$s->endRepVariationSection();

							/* PARAGRAPH */
							$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ));
								$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consecteturetur adipis cingelit. Mauris mollis tempus dui, nec bibendum augue faucibus quis.')
									->addParam('print-in-content', true);
							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Border Animation', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-border', ark_wp_kses( __('Show border animation on hover', 'ark' ) ), 1);
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '#d3d3d9')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Animation Color', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Nonanimated Border Color', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color-nonanimated', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Animation Color', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Box Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text align', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Box Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-equal-height' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}



		$b_top_color_selectors = array(
			'.icon-box-v2 .icon-box-v2-overlay:before' => 'border-color',
		);


		if( $query->getColor('border-color-nonanimated') != null ) {
			$this->_getAssetsRenderer()
				->createCssRule()
				->addParamsString('border-color:' . $query->getColor('border-color-nonanimated') .'!important;' );
		}


		foreach( $b_top_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-top-color:' . $color . ';');
			}
		}

		$b_right_color_selectors = array(
			'.icon-box-v2 .icon-box-v2-overlay:after' => 'border-color',
		);

		foreach( $b_right_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-right-color:' . $color . ';');
			}
		}

		$b_bottom_color_selectors = array(
			'.icon-box-v2 .icon-box-v2-overlay:before' => 'border-color',
		);

		foreach( $b_bottom_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-bottom-color:' . $color . ';');
			}
		}

		$b_left_color_selectors = array(
			'.icon-box-v2 .icon-box-v2-overlay:after' => 'border-color',
		);

		foreach( $b_left_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-left-color:' . $color . ';');
			}
		}

		echo '<section class="icon-box-v2 icon-box-v2-equal-height '. $query->getEscAttr('content-align') .'">';

			if( $query->get('use-border') ){
				echo '<div class="icon-box-v2-overlay"></div>';
			}

			foreach( $query->get('content') as $oneItem ) {
				switch( $oneItem->getVariationType() ) {

					case 'icon':

						$color_selectors = array(
							'.icon-box-v2-icons' => 'icon-color',
						);

						foreach( $color_selectors as $selector => $c ){
							$color = $oneItem->getColor( $c );
							if( $color ) {
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector($selector, false)
									->addParamsString('color:' . $color . ';');
							}
						}

						echo '<i class="icon-box-v2-icons '. $oneItem->getEscAttr('icon') .'"></i>';
						break;

					case 'labels':
						echo '<div class="icon-box-v2-text-area">';

						foreach( $oneItem->get('repeated-lines') as $oneLine ) {
							switch ($oneLine->getVariationType()) {

								case 'sub-title':
									echo '<span class="icon-box-v2-body-subtitle">'. $oneLine->getWpKses('text') .'</span>';
									break;

								case 'title':
									echo '<h3 class="icon-box-v2-body-title">'. $oneLine->getWpKses('text') .'</h3>';
									break;

								case 'description':
									$oneLine->printWpKsesTextarea( 'text', '<p class="icon-box-v2-body-paragraph">', '</p>', '<div class="icon-box-v2-body-paragraph ff-richtext">', '</div>' );
									break;

							}
						}

						echo '</div>';
						break;
				}
			}

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
					$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-box-v2-link')->render( $query );
				echo '></a>';
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
							case 'icon':
								query.addIcon('icon');
								break;
							case 'labels':
								query.get('repeated-lines').each(function (query, variationType) {
									switch (variationType) {
										case 'sub-title':
											query.addHeadingSm('text');
											break;
										case 'title':
											query.addHeadingLg('text');
											break;
										case 'description':
											query.addText('text');
											break;
									}
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