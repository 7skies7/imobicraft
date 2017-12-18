<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_services.html#scrollTo__1750
 **/

class ffElServices1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 1', 'ark' ) ));
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

						$s->endHidingBox();

						$s->startHidingBox('circle-type', array('type-icon') );

							$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-camera');

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
							;

						$s->endHidingBox();

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'shadow-color', '', '#f6f7fb')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Circle Shadow Color', 'ark' ) ) )
						;

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE SUBTITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Time to talk')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', '5 Star Support')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE CONTENT
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('content', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed cursus sapien, vitae fringilla sem. Duis convallis vel nunc at laoreet.')
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Align', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Services Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'services-box-shadow', '', 'rgba(0,0,0,0.07)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Services Box Shadow', 'ark' ) ) )
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

		if( $query->getColor('services-box-shadow') ) {
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString('box-shadow: 0 2px 5px 3px '.$query->getColor('services-box-shadow').';');
		}

		echo '<section class="services-v1 '. $query->getEscAttr('content-align') .'">';
			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {
					case 'circle':

						if( $oneLine->getColor('shadow-color') ) {
							$this->getAssetsRenderer()->createCssRule()
								->addParamsString('box-shadow: 0 5px 10px 0 '.$oneLine->getColor('shadow-color').';');
						}

						if ( 'type-image' == $oneLine->get('circle-type') ){	

							$image = $oneLine->getImage('image')->url;

							if( !empty( $image ) ) {
								$this->getAssetsRenderer()->createCssRule()
									->addParamsString('background-image: url("' . $image . '");');
							}

							if( 'cover' == ( $oneLine->get('bg-size') ) ) {
								$this->getAssetsRenderer()->createCssRule()
									->addParamsString('background-size: cover;');
							}

							echo '<div class="services-v1-icon-wrap radius-circle">';
							echo '</div>';
						} else if ( 'type-icon' == $oneLine->get('circle-type') ){

							$this->getAssetsRenderer()->createCssRule()
								->addParamsString('color: '.$oneLine->getColor('icon-color').';');			

							echo '<div class="services-v1-icon-wrap radius-circle">';
							echo '<i class="services-v1-icon-font '. $oneLine->getWpKses('icon') .'"></i>';
							echo '</div>';
						}


						break;

					case 'title':
						echo '<h3 class="services-v1-title">';
							$oneLine->printWpKses('text');
						echo '</h3>';

						break;

					case 'subtitle':
						ffElServices1::_renderColor( $oneLine->getColor('text-color'), 'color' );

						echo '<span class="services-v1-subtitle">';
							$oneLine->printWpKses('text');
						echo '</span>';

						break;

					case 'content':
						$oneLine->printWpKsesTextarea( 'text', '<p class="services-v1-text">', '</p>', '<div class="services-v1-text ff-richtext">', '</div>' );
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
							case 'subtitle':
								query.addHeadingSm('text');
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