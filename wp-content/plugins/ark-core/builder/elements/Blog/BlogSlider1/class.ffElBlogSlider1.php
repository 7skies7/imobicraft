<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/multiple-page/landing/index.html#scrollTo__3545
 * */

class ffElBlogSlider1 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-slider-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Slider 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, slider 1');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_addTab('Loop', array($this, '_wpLoopSettings'));
		$this->_addTab('Pagination', array($this, '_wpPagination'));

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post', 'ark' ) ) );
				$s->startCssWrapper('ffb-post-wrapper');
				$s->startRepVariableSection('content');

					/* TYPE FEATURED AREA */
					$s->startRepVariationSection('featured-area', ark_wp_kses( __('Featured Area', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('NOTE: The settings below are only for the <strong>Featured Image</strong> case', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$this->_getBlock( ffThemeBlConst::FEATUREDIMG )->injectOptions( $s );
					$s->endRepVariationSection();

					/* TYPE POST TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Post Title', 'ark' ) ) );
						$this->_injectTitleOptions( $s );
					$s->endRepVariationSection();

					/* TYPE META-DATA */
					$s->startRepVariationSection('meta-data', ark_wp_kses( __('Meta Data', 'ark' ) ));
						$this->_getElementMetaOptions( $s );
					$s->endRepVariationSection();

					/* TYPE POST CONTENT */
					$s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
					$s->endRepVariationSection();

					/* TYPE BUTTON */
					$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::BUTTON )->setParam('no-link-options', true)->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();
				$s->endCssWrapper();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post Wrapper', 'ark' ) ) );

				$s->startAdvancedToggleBox('post-wrapper', 'Blog Post Wrapper');

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This is the Blog Post Wrapper that you can edit and style');
					$s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Slider Settings', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-loop', ark_wp_kses( __('Loop slides', 'ark' ) ), 1);
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
				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'stage-padding', '', 100)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Inner Slider Offset (in px)', 'ark' ) ) );
				
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

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
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'md', 'Laptop (MD)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '3')
					->addSelectValue( 1, 1)
					->addSelectValue( 2, 2)
					->addSelectValue( 3, 3)
					->addSelectValue( 4, 4)
					->addSelectValue( 5, 5)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'lg', 'Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '4')
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

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-shadow-color', '', '#eff1f8')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Blog Post Shadow', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Blog Post Background', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link Hover', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-hover-color-underline', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link Hover Underline', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Inner Links', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Inner Links Hover', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-text-color', '', '#727272')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-link-color', '', '#727272')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Inner Links', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-link-hover-color', '', '#727272')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Inner Links Hover', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-separator-color', '', '#727272')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Separator', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-icon-color', '', '#727272')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Icon', 'ark' ) ) );



			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

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

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( $query->get('has-loop') ){
			$dataSlider['loop'] = true;
		}else{
			$dataSlider['loop'] = false;
		}

		if( $query->get('has-autoplay') ){
			$dataSlider['autoplay'] = $query->get('autoplay-speed');
		}else{
			$dataSlider['autoplay'] = false;
		}

		$dataSlider['stagePadding'] = $query->get('stage-padding');
		$dataSlider['autoplaySpeed'] = $query->get('autoplay-speed');
		$dataSlider['speed'] = $query->get('speed');

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

		$dataSlider['xs'] = $query->get('xs');
		$dataSlider['sm'] = $query->get('sm');
		$dataSlider['md'] = $query->get('md');
		$dataSlider['lg'] = $query->get('lg');

		$dataSliderJson = json_encode( $dataSlider);


		$width = false;
		$height  = false;

		switch( $query->getEscAttr('md') ) {
			case 1:
				$width = 1440;
				$height = false;
				break;
			case 2:
				$width = 768;
				$height =  false;
				break;
			case 3:
				$width = 768;
				$height =  false;
				break;
			default:
				$width = 768;
				$height =  false;
				break;
		}

		$loopBlock = $this->_getBlock( ffThemeBuilderBlock::LOOP );
		/**
		 * @var $wpQuery WP_Query
		 */
		$wpQuery = $loopBlock->get( $query );

		$this->_printLoopVarDump( $loopBlock );

		echo '<section class="blog-slider-1">';
		echo '<div class="owl-carousel owl-carousel-l-news-v1" data-slider="'. esc_attr($dataSliderJson) .'">';

			if( $wpQuery->have_posts() ) {
				while( $wpQuery->have_posts() ) {

					$wpQuery->the_post();

					if( !$loopBlock->canBePostPrinted() ) {
						continue;
					}

					ark_Featured_Area::setSizes( 1, $width, $height );
					$featured_area = ark_Featured_Area::getFeaturedArea();

					$postID = get_the_ID();

					echo '<div class="item">';
						
						$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
						echo '<div id="post-'. $postID .'" class="l-news-v1 '. implode(' ', get_post_class('post-wrapper')) .'" >';

							$isInMediaClass = false;

							foreach( $query->get('content') as $postItem ) {
								switch( $postItem->getVariationType() ) {

									case 'featured-area':
										if( $isInMediaClass ){
											echo '</div>';
											$isInMediaClass = false;
										}

										$this->_applySystemTabsOnRepeatableStart( $postItem );
										if ( empty( $featured_area ) ){
											$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
												->setParam('post-id', $postID)
												->setParam('width', $width)
												->setParam('height', $height)
												->imgIsResponsive()
												->render( $postItem );
										} else {
											echo ( $featured_area );
										}
										$this->_applySystemTabsOnRepeatableEnd( $postItem );
										break;

									case 'title':
										if( !$isInMediaClass ){
											echo '<div class="l-news-v1-media">';
											$isInMediaClass = true;
										}

										$this->_applySystemTabsOnRepeatableStart( $postItem );
										echo '<h4 class="l-news-v1-title">';
											$this->_printPostTitle( $postItem );
										echo '</h4>';
										$this->_applySystemTabsOnRepeatableEnd( $postItem );

										break;


									case 'meta-data':
										if( !$isInMediaClass ){
											echo '<div class="l-news-v1-media">';
											$isInMediaClass = true;
										}

										$this->_applySystemTabsOnRepeatableStart( $postItem );
										echo '<span class="l-news-v1-day">';
											$this->_renderMetaElement( $postItem );
										echo '</span>';
										$this->_applySystemTabsOnRepeatableEnd( $postItem );

										break;

									case 'p-content':
										if( !$isInMediaClass ){
											echo '<div class="l-news-v1-media">';
											$isInMediaClass = true;
										}

										$this->_applySystemTabsOnRepeatableStart( $postItem );
										echo '<div class="blog-slider-1-post-content">';
											$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
										echo '</div>';
										$this->_applySystemTabsOnRepeatableEnd( $postItem );

										break;


									case 'button':
										if( !$isInMediaClass ){
											echo '<div class="l-news-v1-media">';
											$isInMediaClass = true;
										}

										$this->_applySystemTabsOnRepeatableStart( $postItem );
										echo '<div class="blog-slider-1-button">';
										$postURL = esc_url( get_permalink() );
										$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($postItem);
										echo '</div>';
										$this->_applySystemTabsOnRepeatableEnd( $postItem );
										break;

								}
							}

							if( $isInMediaClass ){
								echo '</div>';
							}
						echo '</div>';
						$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
						
					echo '</div>';

				}
			}

		echo '</div>';
		echo '</section>';

		/* COLORS */

		if( $query->getColor('content-shadow-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .l-news-v1', false)
				->addParamsString('box-shadow: 7px 7px 5px 0 '.$query->getColor('content-shadow-color').';');
		}

		if( $query->getColor('content-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .l-news-v1', false)
				->addParamsString('background: '.$query->getColor('content-bg-color').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .l-news-v1-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .l-news-v1-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('title-text-hover-color-underline') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .l-news-v1-title a:before', false)
				->addParamsString('background-color: '.$query->getColor('title-text-hover-color-underline').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .blog-slider-1-post-content', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .blog-slider-1-post-content p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .blog-slider-1-post-content a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .blog-slider-1-post-content a:hover', false)
				->addParamsString('color: '.$query->getColor('content-link-hover-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .l-news-v1-day .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .l-news-v1-day .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .l-news-v1-day .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .l-news-v1-day .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-l-news-v1 .l-news-v1-day .ff-meta-icon', false)
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
							query.addPlainText( 'Post Featured Image' );
							query.addBreak();
							break;
						case 'title':
							query.addPlainText( 'Post Title' );
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