<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/multiple-page/landing/index.html
 **/

class ffElServices14 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-14');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 14', 'ark' ) ));
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
					/* TYPE CIRCLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('circle', ark_wp_kses( __('Circle', 'ark' ) ));

						$s->addOptionNL(ffOneOption::TYPE_SELECT, 'circle-type', '', 'type-icon')
							->addSelectValue(esc_attr( __('Icon', 'ark' ) ), 'type-icon')
							->addSelectValue(esc_attr( __('Background Image', 'ark' ) ), 'type-image')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Content Type', 'ark' ) ) );
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startHidingBox('circle-type', array('type-image') );

							$s->addOptionNL( ffOneOption::TYPE_IMAGE, 'image', ark_wp_kses( __('Background Image', 'ark' ) ), '');

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'bg-size', '', 'auto')
								->addSelectValue(esc_attr( __('Auto', 'ark' ) ), 'auto')
								->addSelectValue(esc_attr( __('Cover', 'ark' ) ), 'cover')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Size', 'ark' ) ) );
							;

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->endHidingBox();

						$s->startHidingBox('circle-type', array('type-icon') );

							$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-camera');

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) )
							;

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->endHidingBox();

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'services-bg', '', '#f7f8fa')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Circle Background Color', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'services-hover-bg', '', '#009688')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Circle Background Hover Color', 'ark' ) ) )
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'services-hover-border-circle', '', 'rgba(0, 150, 136, 0.3)')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Circle Border Hover Color', 'ark' ) ) )
						;

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Notifications')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE CONTENT
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('content', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'The entire product team needs to commit to regularly conducting user research.')
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

	protected function _renderColor( $query, $cssAttribute, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		/* element bg */
		if( $query->getColor('el-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-services-v2', false)
				->addParamsString('background-color: '.$query->getColor('el-bg').';');
		}

		/* elem box-shadow colors */
		if( $query->getColor('el-shadow') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-services-v2')
				->addParamsString('box-shadow: 7px 7px 5px 0 ' . $query->getColor('el-shadow') . ';');
		}

		echo '<section class="l-services-v2 '. $query->getEscAttr('content-align') .'">';
			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {
					case 'circle':

						if( $oneLine->getColor('services-bg') ) {
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->removeSelectorFromScope()
								->addSelector(' .l-services-v2-icon-wrap', false)
								->addParamsString('background-color: '.$oneLine->getColor('services-bg').';');
						}

						if( $oneLine->getColor('services-hover-bg') ) {
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->removeSelectorFromScope()
								->addSelector(':hover .'.$this->_getSelectorFromStorageWithoutRemovingIt().'.l-services-v2-icon-wrap', false)
								->addParamsString('background-color: '.$oneLine->getColor('services-hover-bg').';');
						}

						if( $oneLine->getColor('services-hover-border-circle') ) {
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->removeSelectorFromScope()
								->addSelector(':hover .'.$this->_getSelectorFromStorageWithoutRemovingIt().'.l-services-v2-icon-wrap:before', false)
								->addParamsString('border-color: '.$oneLine->getColor('services-hover-border-circle').';');
						}

						if ( 'type-image' == $oneLine->get('circle-type') ){

							$image = $oneLine->getImage('image')->url;

							if( !empty( $image ) ) {
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector(' .l-services-v2-bg-image', false)
									->addParamsString('background-image: url('.$image.');');
							}

							echo '<div class="l-services-v2-icon-wrap">';
								echo '<div class="l-services-v2-bg-image l-services-v2-bg-image-size-'. $oneLine->getEscAttr('bg-size') .'">';
								echo '</div>';
							echo '</div>';
						} else if ( 'type-icon' == $oneLine->get('circle-type') ){

							if( $oneLine->getColor('icon-color') ) {
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector('.l-services-v2-icon-wrap', false)
									->addParamsString('color: '.$oneLine->getColor('icon-color').';');
							}

							if( $oneLine->getColor('icon-hover-color') ) {
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->removeSelectorFromScope()
									->addSelector(':hover .'.$this->_getSelectorFromStorageWithoutRemovingIt().'.l-services-v2-icon-wrap', false)
									->addParamsString('color: '.$oneLine->getColor('icon-hover-color').';');
							}

							echo '<div class="l-services-v2-icon-wrap">';
								echo '<i class="ff-l-services-v2-icon '. $oneLine->getWpKses('icon') .'"></i>';
							echo '</div>';
						}

						break;

					case 'title':
						echo '<h3 class="l-services-v2-title">';
							$oneLine->printWpKses('text');
						echo '</h3>';

						break;


					case 'content':
						$oneLine->printWpKsesTextarea( 'text', '<p class="services-v14-text">', '</p>', '<div class="services-v14-text ff-richtext">', '</div>' );
						break;

					case 'button':
						echo '<div class="l-services-v2-buttons-wrapper">';
							$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneLine );
						echo '</div>';
						break;
				}
			}


			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
					$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'l-services-v2-link')->render( $query );
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
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'circle':
								if ( 'type-image' == query.get('circle-type') ){
									query.addImage('image');
								} else if ( 'type-icon' == query.get('circle-type') ){
									query.addIcon('icon');
								}
								break;
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'content':
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