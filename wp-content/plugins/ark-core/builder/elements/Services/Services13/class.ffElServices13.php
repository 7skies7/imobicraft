<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/multiple-page/landing/index_layout_2.html
 */

class ffElServices13 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-13');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 13', 'ark' ) ) );
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
					/* TYPE HEADING
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Creative designs for the modern day professional.')
							->addParam('print-in-content', true)
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-color', '', '#b260ce')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title Color', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-hover-color', '', '#009688')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title Hover Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE PARAGRAPH
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('paragraph', ark_wp_kses( __('Paragraph', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'How does the UX designer ensure that the finished product is as close to his vision as possible? The key is collaboration. Effective collaboration is not only mission-critical.')
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


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Settings', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-lightbulb');

				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'icon-position', '', 'icon-left')
					->addSelectValue(esc_attr( __('Left', 'ark' ) ),'icon-left')
					->addSelectValue(esc_attr( __('Right', 'ark' ) ),'icon-right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Position', 'ark' ) ) )
				;

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) )
				;

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '#b260ce')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background and Ripples Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hover-color', '', '#009688')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background and Ripples Hover Color', 'ark' ) ) )
				;

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'box-color', '', 'rgba(178, 96, 206, 0.4)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Shadow Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'box-hover-color', '', 'rgba(0, 150, 136, 0.4)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Shadow Hover Color', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT,'align','','text-left')
					->addSelectValue(esc_attr( __('Left', 'ark' ) ),'text-left')
					->addSelectValue(esc_attr( __('Center', 'ark' ) ),'text-center')
					->addSelectValue(esc_attr( __('Right', 'ark' ) ),'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Box Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Services Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-bg', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-shadow', '', '#eff1f8')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Box Shadow', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null, $space = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors($space)
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		/* icon colors */
		ffElServices13::_renderColor( $query->getColor('icon-color'), 'color', '.l-services-v1 .l-services-v1-icon', false );
		ffElServices13::_renderColor( $query->getColor('icon-hover-color'), 'color', '.l-services-v1:hover .l-services-v1-icon', false );

		/* bg-icon colors */
		ffElServices13::_renderColor( $query->getColor('color'), 'background-color', '.l-services-v1 .l-services-v1-icon', false );
		ffElServices13::_renderColor( $query->getColor('hover-color'), 'background-color', '.l-services-v1:hover .l-services-v1-icon', false );

		/* icon */
		if( $query->getColor('box-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-services-v1 .l-services-v1-icon')
				->addParamsString('box-shadow: 0 0 5px 2px ' . $query->getColor('box-color') . ';');
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-services-v1:hover .l-services-v1-icon')
				->addParamsString('box-shadow: 0 0 5px 2px ' . $query->getColor('box-hover-color') . ';');
		}

		/* element bg */
		if( $query->getColor('el-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-services-v1', false)
				->addParamsString('background-color: '.$query->getColor('el-bg').';');
		}

		/* border-circles colors */
		ffElServices13::_renderColor( $query->getColor('color'), 'border-color', '.l-services-v1 .before', false );
		ffElServices13::_renderColor( $query->getColor('color'), 'border-color', '.l-services-v1 .after', false );

		ffElServices13::_renderColor( $query->getColor('hover-color'), 'border-color', '.l-services-v1:hover .before', false );
		ffElServices13::_renderColor( $query->getColor('hover-color'), 'border-color', '.l-services-v1:hover .after', false );

		/* elem box-shadow colors */
		if( $query->getColor('el-shadow') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-services-v1')
				->addParamsString('box-shadow: 7px 7px 5px 0 ' . $query->getColor('el-shadow') . ';');
		}

		echo '<section class="l-services-v1 l-services-v1-icon-two '. $query->get('align') .' '. $query->get('icon-position') .'">';

			echo '<div class="l-services-v1-media">';
				echo '<span class="l-services-v1-effect">';
					echo '<span class="before"></span>';

 						echo '<i class="l-services-v1-icon '.$query->getWpKses('icon').'"></i>';

					echo '<span class="after"></span>';
				echo '</span>';
			echo '</div>';

			if( $query->exists('content') ) {
				echo '<div class="l-services-v1-content">';

					foreach( $query->get('content') as $oneLine ) {
						switch($oneLine->getVariationType()){

							case 'title':

								ffElServices13::_renderColor( $oneLine->getColor('title-color'), 'color', '.l-services-v1-title', false );

								if( $oneLine->getColor('title-hover-color') ) {
									$this->getAssetsRenderer()->createCssRule()
										->setAddWhiteSpaceBetweenSelectors(false)
										->removeSelectorFromScope()
										->addSelector(':hover .'.$this->_getSelectorFromStorageWithoutRemovingIt().'.l-services-v1-title', false)
										->addParamsString('color: '.$oneLine->getColor('title-hover-color').';');
								}

								echo '<h3 class="l-services-v1-title">';
									$oneLine->printWpKses('text');
								echo '</h3>';
								break;

							case 'paragraph':
								$oneLine->printWpKsesTextarea( 'text', '<p class="l-services-v1-text">', '</p>', '<div class="l-services-v1-text ff-richtext">', '</div>' );
								break;

							case 'button':
								echo '<span class="l-services-v1-button-wrapper">';
									$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneLine );
								echo '</span>';
								break;

						}
					}

				echo '</div>';
			}


			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
					$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'l-services-v1-link')->render( $query );
				echo '>';
			}

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '</a>';
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				query.addIcon('icon');

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingSm('text');
								break;
							case 'paragraph':
								query.addText('text');
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