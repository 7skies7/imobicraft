<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_slider_block.html#scrollTo__1200
 */

class ffElSlider3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'slider-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Slider 3', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'slider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'slider, image slider');
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
					$s->startRepVariationSection('image', ark_wp_kses( __('Image', 'ark' ) ));

						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->setParam('width', 1140)
							->setParam('height', 760)
							->injectOptions( $s );

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Arrow Navigation', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'navigation', ark_wp_kses( __('Use Arrow navigation', 'ark' ) ), 1);
				
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_ICON, 'l-arrow', ark_wp_kses( __('Left Arrow', 'ark' ) ), 'ff-font-awesome4 icon-angle-left')
					->addParam('print-in-content', true)
				;

				$s->addOptionNL( ffOneOption::TYPE_ICON, 'r-arrow', ark_wp_kses( __('Right Arrow', 'ark' ) ), 'ff-font-awesome4 icon-angle-right')
					->addParam('print-in-content', true)
				;

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'arrow-size', '', '18')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Size (in px)', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrow-bg', '', 'rgba(255, 255, 255, 0.7)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Inactive', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrow-bg-active', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Active', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrow-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color - Inactive', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrow-color-active', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color - Active', 'ark' ) ) );


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Thumbnail Navigation', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'img-navigation', ark_wp_kses( __('Show Thumbnail Navigation', 'ark' ) ), 1);

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('NOTE: Thumbnail Navigation will be automatically hidden on mobile phones', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'imgnav-item-size', '', '50')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Size (in px)', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'imgnav-bg', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Thumbnail Navigation Wrapper Background Color', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'imgnav-border', '', '#f7f8fa')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Thumbnail Navigation Wrapper Border Color', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'imgnav-item-border', '', '#ebeef6')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Thumbnail Border Color', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'imgnav-item-border-active', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Thumbnail Border Active Color', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColors( ffOptionsQueryDynamic $query ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$arrow_size = absint( $query->get('arrow-size') );
		if( ! empty($arrow_size) ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.theme-carousel-control-v1 .carousel-control-arrows-v1')
				->addParamsString(
					'width:' . (2*$arrow_size) . 'px;'
					. 'height:' . (2*$arrow_size) . 'px;'
					. 'line-height:' . (2*$arrow_size) . 'px;'
					. 'margin-top:-'.$arrow_size . 'px;'
				);
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.theme-carousel-control-v1 .carousel-control-arrows-v1')
				->addParamsString('font-size:' . $arrow_size . 'px;');
		}

		$arrow_bg = $query->getColor('arrow-bg');
		if( !empty( $arrow_bg ) ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector( '.theme-carousel-control-v1 .carousel-control-arrows-v1' )
				->addParamsString('background-color:' . $arrow_bg );
		}

		$arrow_bg_active = $query->getColor('arrow-bg-active');
		if( !empty( $arrow_bg_active ) ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector( '.theme-carousel-control-v1 .carousel-control-arrows-v1:hover' )
				->addParamsString('background-color:' . $arrow_bg_active );
		}

		$arrow_color = $query->getColor('arrow-color');
		if( !empty( $arrow_color ) ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector( '.theme-carousel-control-v1 .carousel-control-arrows-v1' )
				->addParamsString('color:' . $arrow_color );
		}

		$arrow_color_active = $query->getColor('arrow-color-active');
		if( !empty( $arrow_color_active ) ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector( '.theme-carousel-control-v1 .carousel-control-arrows-v1:hover' )
				->addParamsString('color:' . $arrow_color_active );
		}

		$imgnav_item_size = absint( $query->get('imgnav-item-size') );
		if( ! empty($imgnav_item_size) ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.theme-carousel-indicators-v5 li .theme-carousel-indicators-item')
				->addParamsString('width:' . $imgnav_item_size . 'px;height:' . $imgnav_item_size . 'px;');
		}

		$imgnav_bg = $query->getColor('imgnav-bg');
		if( !empty($imgnav_bg) ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.theme-carousel-indicators-v5')
				->addParamsString('background-color:'.$imgnav_bg);
		}

		$imgnav_border = $query->getColor('imgnav-border');
		if( !empty($imgnav_border) ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.theme-carousel-indicators-v5')
				->addParamsString('border-color:'.$imgnav_border);
		}

		$imgnav_item_border = $query->getColor('imgnav-item-border');
		if( !empty($imgnav_item_border) ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.theme-carousel-indicators-v5 li .theme-carousel-indicators-item')
				->addParamsString('border-color:'.$imgnav_item_border);
		}

		$imgnav_item_border_active = $query->getColor('imgnav-item-border-active');
		if( !empty($imgnav_item_border_active) ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.theme-carousel-indicators-v5 li.active .theme-carousel-indicators-item')
				->addParamsString('border-color:'.$imgnav_item_border_active);
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$this->_renderColors($query);

		$thumbSize = absint( $query->get('imgnav-item-size') );

		echo '<section id="'.$uniqueId.'" class="carousel slide carousel-fade" data-ride="carousel">';

			echo '<div class="carousel-inner" role="listbox">';

				foreach( $query->get('content') as $key => $oneSlide ) {

					$active = '';
					if( 0 == $key ){
						$active = 'active';
					}

					echo '<div class="item '. $active .'">';
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->setParam('width', 1140)
							->setParam('height', 760)
							->render( $oneSlide );
					echo '</div>';

				}

				if( $query->get('navigation') ){
					echo '<a class="left carousel-control theme-carousel-control-v1 radius-3" href="#'.$uniqueId.'" role="button" data-slide="prev">';
						echo '<span class="carousel-control-arrows-v1 radius-3 '. $query->getEscAttr('l-arrow') .'" aria-hidden="true"></span>';
						echo '<span class="sr-only">Previous</span>';
					echo '</a>';
					echo '<a class="right carousel-control theme-carousel-control-v1 radius-3" href="#'.$uniqueId.'" role="button" data-slide="next">';
						echo '<span class="carousel-control-arrows-v1 radius-3 '. $query->getEscAttr('r-arrow') .'" aria-hidden="true"></span>';
						echo '<span class="sr-only">Next</span>';
					echo '</a>';
				}

			echo '</div>';

			if( $query->get('img-navigation') ){
				echo '<ol class="carousel-indicators theme-carousel-indicators-v5">';

					foreach( $query->get('content') as $key => $oneSlide ) {

						$active = '';
						if( 0 == $key ){
							$active = 'class="active"';
						}

						echo '<li data-target="#'.$uniqueId.'" data-slide-to="'. $key .'" '. $active .'>';
							$this->_getBlock( ffThemeBlConst::IMAGE )
								->setParam('width', $thumbSize )
								->setParam('height', $thumbSize )
								->setParam('css-class', 'theme-carousel-indicators-item radius-circle')
								->render( $oneSlide );
						echo '</li>';

					}

				echo '</ol>';
			}

		echo '</section>'; 

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $$elementPreview, $element, block, preview ) {

				if(query.queryExists('content')) {
					// query.addIcon('l-arrow');
					// query.addIcon('r-arrow');
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'image':
								block.render('image', query);
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}