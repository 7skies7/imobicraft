<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_business_4.html#scrollTo__4000
 * */

class ffElBlogSlider2 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-slider-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Slider 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, slider 2');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_addTab('Loop', array($this, '_wpLoopSettings'));
		$this->_addTab('Pagination', array($this, '_wpPagination'));

		$this->_setColor('dark');
	}

	private function _getImageWidthBasedOnNumberOfColumns( $numberOfColumns ) {
		switch( $numberOfColumns ) {
			case 1:
				$width = 1440;
				break;
			case 2:
				$width = 768;
				break;
			case 3:
				$width = 768;
				break;
			default:
				$width = 768;
				break;
		}

		return $width;
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('- No support for multimedia <strong>Featured Area</strong>, only <strong>Featured Images</strong>', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post', 'ark' ) ) );
				$s->startCssWrapper('ffb-post-wrapper');
				$s->startRepVariableSection('content');

				/* TYPE FEATURED AREA */
				$s->startRepVariationSection('featured-image', ark_wp_kses( __('Featured Image', 'ark' ) ) );
					$this->_getBlock( ffThemeBlConst::FEATUREDIMG )->injectOptions( $s );
				$s->endRepVariationSection();

				/* TYPE POST TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Post Title', 'ark' ) ) );
						$this->_injectTitleOptions( $s );
					$s->endRepVariationSection();

				/* TYPE POST CONTENT */
				$s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ) );
					$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
				$s->endRepVariationSection();

				/* TYPE META-DATA */
				$s->startRepVariationSection('meta-data', ark_wp_kses( __('Meta Data', 'ark' ) ) );
					$this->_getElementMetaOptions( $s );
				$s->endRepVariationSection();

				$s->endRepVariableSection();
				$s->endCssWrapper();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Lightbox Button', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-lb-button', ark_wp_kses( __('Show Lightbox Button', 'ark' ) ), 1);
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->startHidingBox('use-lb-button', 'checked');
					$s->startCssWrapper('ffb-post-wrapper');
					$s->startAdvancedToggleBox('lb-button', 'Lightbox Button');

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Enlarge')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-expand')
							->addParam('print-in-content', true)
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Icon Color', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hover-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Icon Hover Color', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Background Color', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Background Hover Color', 'ark' ) ) );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tooltip-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Tooltip Text Color', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tooltip-bg-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Tooltip Background Color', 'ark' ) ) );

						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('NOTE: Lightbox Button will be displayed only when the Blog Post has a Featured Image', 'ark' ) ) );

					$s->endAdvancedToggleBox();
					$s->endCssWrapper();
				$s->endHidingBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post Wrapper', 'ark' ) ) );

				$s->startAdvancedToggleBox('post-wrapper', 'Blog Post Wrapper');

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This is the Blog Post Wrapper that you can edit and style');
					$s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Slider Settings', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-loop', ark_wp_kses( __('Loop slides', 'ark' ) ), 1);
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-pagination', ark_wp_kses( __('Show navigation', 'ark' ) ), 1);
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-autoplay', ark_wp_kses( __('Autoplay', 'ark' ) ), 0);
				$s->startHidingBox('has-autoplay', 'checked');
					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-hover-pause', ark_wp_kses( __('Pause autoplay on hover', 'ark' ) ), 1);
					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'autoplay-speed', '', 4000)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Autoplay speed (in ms)', 'ark' ) ) );
				$s->endHidingBox();
				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'speed', '', 450)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Sliding speed (in ms)', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Columns Settings', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'xs', 'Phone (XS)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '1')
					->addSelectValue( 1, 1)
					->addSelectValue( 2, 2)
					->addSelectValue( 3, 3)
					->addSelectValue( 4, 4)
					->addSelectValue( 5, 5)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'sm', 'Tablet (SM)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '2')
					->addSelectValue( 1, 1)
					->addSelectValue( 2, 2)
					->addSelectValue( 3, 3)
					->addSelectValue( 4, 4)
					->addSelectValue( 5, 5)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'md', 'Laptop (MD)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '2')
					->addSelectValue( 1, 1)
					->addSelectValue( 2, 2)
					->addSelectValue( 3, 3)
					->addSelectValue( 4, 4)
					->addSelectValue( 5, 5)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'lg', 'Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '3')
					->addSelectValue( 1, 1)
					->addSelectValue( 2, 2)
					->addSelectValue( 3, 3)
					->addSelectValue( 4, 4)
					->addSelectValue( 5, 5)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) )
				;
				
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'slide-margin', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom horizontal gap between columns (in px)', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Blog Post Background', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'dots', '', '#00bcd4')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Navigation Dots', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'dots-active', '', '#00bcd4')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Navigation Dot Active', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link Hover', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Inner Links', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Inner Links Hover', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-link-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Inner Links', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-link-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Inner Links Hover', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-separator-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Separator', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-icon-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Icon', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}


	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 */
	protected function _wpLoopSettings( $s ) {
		$this->_getBlock( ffThemeBuilderBlock::LOOP )->injectOptions( $s );
	}

	protected function _wpPagination( $s ) {
		$this->_getBlock( ffThemeBlConst::PAGINATION )->injectOptions( $s );
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {


		if( $query->get('has-loop') ){
			$dataSlider['loop'] = true;
		}else{
			$dataSlider['loop'] = false;
		}

		if( $query->get('has-pagination') ){
			$dataSlider['dots'] = true;
		}else{
			$dataSlider['dots'] = false;
		}

		if( $query->get('has-autoplay') ){
			$dataSlider['autoplay'] = true;
		}else{
			$dataSlider['autoplay'] = false;
		}

		if( '' === $query->get('slide-margin') ){
			$dataSlider['slideMargin'] = "30";
		} else {
			$dataSlider['slideMargin'] = $query->get('slide-margin');
		}

		if( $query->get('has-hover-pause') ){
			$dataSlider['hoverPause'] = true;
		}else{
			$dataSlider['hoverPause'] = false;
		}

		$dataSlider['autoplaySpeed'] = $query->get('autoplay-speed');
		$dataSlider['speed'] = $query->get('speed');

		$dataSlider['xs'] = $query->get('xs');
		$dataSlider['sm'] = $query->get('sm');
		$dataSlider['md'] = $query->get('md');
		$dataSlider['lg'] = $query->get('lg');

		$dataSliderJson = json_encode( $dataSlider);


		$loopBlock = $this->_getBlock( ffThemeBuilderBlock::LOOP );
		/**
		 * @var $wpQuery WP_Query
		 */
		$wpQuery = $loopBlock->get( $query );

		$this->_printLoopVarDump( $loopBlock );

		echo '<section class="blog-slider-2">';
		echo '<div class="owl-carousel owl-carousel-news-v12" data-slider="'. esc_attr($dataSliderJson) .'">';

			if( $wpQuery->have_posts() ) {
				while( $wpQuery->have_posts() ) {

					$wpQuery->the_post();

					if( !$loopBlock->canBePostPrinted() ) {
						continue;
					}

					ark_Featured_Area::getFeaturedArea();

					$postID = get_the_ID();
					$imgURL = wp_get_attachment_url( get_post_thumbnail_id( $postID ) );

					echo '<div class="item">';
						$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
						echo '<div id="post-'. $postID .'" class="news-v12 '. implode(' ', get_post_class('post-wrapper')) .'" >';

							$isInContentClass = false;

							foreach( $query->get('content') as $postItem ) {
								switch( $postItem->getVariationType() ) {

									case 'featured-image':
										if( $isInContentClass){
											echo '</div>';
											$isInContentClass = false;
										}

										$this->_applySystemTabsOnRepeatableStart( $postItem );


										$width = $this->_getImageWidthBasedOnNumberOfColumns( $query->get('md') );

										$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
											->setParam('post-id', $postID)
											->setParam('css-class', 'news-v12-img')
											->setParam('width', $width )
											->imgIsResponsive()
											->render( $postItem );
										$this->_applySystemTabsOnRepeatableEnd( $postItem );

										// LIGHTBOX BUTTON - START

										if( ! $isInContentClass){
											echo '<div class="news-v12-content">';
											$isInContentClass = true;
										}

										if( $imgURL && $query->get('use-lb-button') ) {

											echo '<div class="news-v12-video">';

												echo '<span class="news-v12-video-tooltip radius-5">'. $query->getWpKses('lb-button text') .'</span>';
												$this->_advancedToggleBoxStart( $query, 'lb-button');
												echo '<a class="news-v12-video-link image-popup-up radius-circle freshframework-lightbox-image" href="'. esc_url( $imgURL ) .'">';
													echo '<i class="'. $query->getEscAttr( 'lb-button icon' ) .'"></i>';
												echo '</a>';
												$this->_advancedToggleBoxEnd( $query, 'lb-button');
											echo '</div>';

										} else {
											echo '<span></span>';
										}

										// LIGHTBOX BUTTON - END

										break;

									case 'title':
										if( ! $isInContentClass){
											echo '<div class="news-v12-content">';
											$isInContentClass = true;
										}

										$this->_applySystemTabsOnRepeatableStart( $postItem );
										echo '<h2 class="news-v12-title">';
											$this->_printPostTitle( $postItem );
										echo '</h2>';
										$this->_applySystemTabsOnRepeatableEnd( $postItem );

										break;

									case 'p-content':
										if( ! $isInContentClass){
											echo '<div class="news-v12-content">';
											$isInContentClass = true;
										}

										$this->_applySystemTabsOnRepeatableStart( $postItem );
										echo '<div class="news-v12-text">';
											$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
										echo '</div>';
										$this->_applySystemTabsOnRepeatableEnd( $postItem );

										break;

									case 'meta-data':
										if( ! $isInContentClass){
											echo '<div class="news-v12-content">';
											$isInContentClass = true;
										}

										$this->_applySystemTabsOnRepeatableStart( $postItem );
										echo '<div class="blog-grid-supplemental">';
											echo '<span class="blog-grid-supplemental-title">';
												$this->_renderMetaElement( $postItem );
											echo '</span>';
										echo '</div>';
										$this->_applySystemTabsOnRepeatableEnd( $postItem );

										break;

								}
							}

							if( $isInContentClass){
								echo '</div>';
								$isInContentClass = false;
							}

						echo '</div>';
						$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
					echo '</div>';

				}
			}

		echo '</div>';
		echo '</section>';

		/* LIGHTBOX BUTTON COLORS */

		if( $query->getColor('lb-button bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v12-video .news-v12-video-link', false)
				->addParamsString('background-color: '.$query->getColor('lb-button bg-color').';');
		}

		if( $query->getColor('lb-button bg-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v12-video .news-v12-video-link:hover', false)
				->addParamsString('background-color: '.$query->getColor('lb-button bg-hover-color').';');
		}

		if( $query->getColor('lb-button color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v12-video .news-v12-video-link', false)
				->addParamsString('color: '.$query->getColor('lb-button color').';');
		}

		if( $query->getColor('lb-button hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v12-video .news-v12-video-link:hover', false)
				->addParamsString('color: '.$query->getColor('lb-button hover-color').';');
		}

		if( $query->getColor('lb-button bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v12-video .news-v12-video-tooltip', false)
				->addParamsString('background-color: '.$query->getColor('lb-button bg-color').';');
		}

		if( $query->getColor('lb-button bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v12-video .news-v12-video-tooltip:after', false)
				->addParamsString('border-color: '.$query->getColor('lb-button bg-color').' transparent transparent transparent;');
		}

		/* COLORS */

		if( $query->getColor('content-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v12-content', false)
				->addParamsString('background-color: '.$query->getColor('content-bg').';');
		}

		if( $query->getColor('dots') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-dots .owl-dot:not(.active) span', false)
				->addParamsString('border-color: '.$query->getColor('dots').';');
		}

		if( $query->getColor('dots-active') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-dots .owl-dot.active span', false)
				->addParamsString('border-color: '.$query->getColor('dots-active').';');
		}

		if( $query->getColor('dots-active') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-dots .owl-dot.active span', false)
				->addParamsString('background-color: '.$query->getColor('dots-active').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-news-v12 .news-v12-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-news-v12 .news-v12-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-news-v12 .news-v12-text', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-news-v12 .news-v12-text p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-news-v12 .news-v12-text a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-news-v12 .news-v12-text a:hover', false)
				->addParamsString('color: '.$query->getColor('content-link-hover-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental .ff-meta-icon', false)
				->addParamsString('color: '.$query->getColor('meta-icon-color').';');
		}

		$loopBlock->resetOnTheEnd();
	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				query.addHeadingSm( 'lg', 'Blog columns: ' );
				query.addBreak();

				query.get('content').each(function(query, variationType ){
					switch(variationType){
						case 'featured-image':
							query.addPlainText( 'Featured Image' );
							query.addBreak();
							break;
						case 'lightbox-icon':
							query.addText( 'text' );
							query.addIcon( 'icon');
							query.addBreak();
							break;
						case 'title':
							query.addPlainText( 'Post Title' );
							query.addBreak();
							break;
						case 'p-content':
							query.addPlainText( 'Post Content' );
							query.addBreak();
							break;
						case 'meta-data':
							query.addPlainText( 'Post Meta' );
							query.addBreak();
							break;
					}

				});

			}
		</script data-type="ffscript">
		<?php
	}


}