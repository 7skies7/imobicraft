<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/multiple-page/landing/services.html
 **/

class ffElServices15 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-15');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 15', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'services');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE IMAGE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('image', ark_wp_kses( __('Image', 'ark' ) ));

						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()						
							->setParam('width', 738)
							->injectOptions( $s );

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Link', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Wonderful design')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Text', 'ark' ) ) )
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-color', '', '#34343c')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title Color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-hover-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title Hover Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Align', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Services Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-bg', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-shadow', '', '#f2f4f9')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Box Shadow', 'ark' ) ) )
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

		/* elem box-shadow colors */
		if( $query->getColor('el-shadow') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-services-v4', false)
				->addParamsString('box-shadow: 7px 7px 7px 1px ' . $query->getColor('el-shadow') . ';');
		}

		/* element bg */
		if( $query->getColor('el-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-services-v4', false)
				->addParamsString('background-color: '.$query->getColor('el-bg').';');
		}

		echo '<section class="l-services-v4 '. $query->getEscAttr('content-align') .'">';
			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {
					case 'image':

						$this->_getBlock(ffThemeBlConst::IMAGE)
							->imgIsResponsive()
							->imgIsFullWidth()						
							->setParam('width', 738)
							->setParam('css-class', 'l-services-v4-img')
							->render($oneLine);

						break;

					case 'title':

						echo '<div class="l-services-v4-media">';
							if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneLine ) ) {

								if( $oneLine->getColor('title-color') ) {
									$this->getAssetsRenderer()->createCssRule()
										->setAddWhiteSpaceBetweenSelectors(false)
										->addSelector('', false)
										->addParamsString('color: ' . $oneLine->getColor('title-color') . ';');
								}

								if( $oneLine->getColor('title-hover-color') ) {
									$this->getAssetsRenderer()->createCssRule()
										->setAddWhiteSpaceBetweenSelectors(false)
										->addSelector(':hover', false)
										->addParamsString('color: ' . $oneLine->getColor('title-hover-color') . ';');
								}

								echo '<h2 class="l-services-v4-title">';
									$toPrint = '<a '.$this->_getBlock( ffThemeBuilderBlock::LINK )->get( $oneLine ).'>';
									$toPrint .= $oneLine->getWpKses('text');
									$toPrint .= '</a>';
									// Escaped services title
									echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneLine) );
								echo '</h2>';
							}else{

								if( $oneLine->getColor('title-color') ) {
									$this->getAssetsRenderer()->createCssRule()
										->setAddWhiteSpaceBetweenSelectors(false)
										->addSelector('.l-services-v4-title', false)
										->addParamsString('color: ' . $oneLine->getColor('title-color') . ';');
								}

								if( $oneLine->getColor('title-hover-color') ) {
									$this->getAssetsRenderer()->createCssRule()
										->setAddWhiteSpaceBetweenSelectors(false)
										->addSelector('.l-services-v4-title:hover', false)
										->addParamsString('color: ' . $oneLine->getColor('title-hover-color') . ';');
								}

								$toPrint = '<h2 class="l-services-v4-title">';
								$toPrint .= $oneLine->getWpKses('text');
								$toPrint .= '</h2>';
								// Escaped services title
								echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneLine) );
							}
						echo '</div>';

						break;
				}
			}
 
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'image':
								blocks.render('image', query);
								break;
							case 'title':
								query.addLink('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}