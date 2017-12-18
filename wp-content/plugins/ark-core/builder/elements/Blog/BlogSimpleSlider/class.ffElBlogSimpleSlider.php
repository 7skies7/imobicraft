<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_business_1.html#scrollTo__6700
 * */

class ffElBlogSimpleSlider extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-simple-slider');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Simple Slider', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, simple slider');
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
					$s->startRepVariationSection('title', ark_wp_kses( __('Post Title With Date', 'ark' ) ));
						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-date', ark_wp_kses( __('Show Date', 'ark' ) ), 1);
						$s->startHidingBox('has-date', 'checked');
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'date-format', '', 'd M')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Date format', 'ark' ) ) )
							;
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Available date formats: <a href="//php.net/manual/en/function.date.php" target="_blank">Date PHP function manual</a>', 'ark' ) ) );
						$s->endHidingBox();

						$this->_injectTitleOptions( $s );
					$s->endRepVariationSection();

					/* TYPE POST CONTENT */
					$s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
					$s->endRepVariationSection();

					/* TYPE META-DATA */
					$s->startRepVariationSection('meta-data', ark_wp_kses( __('Meta Data', 'ark' ) ));
						$this->_getElementMetaOptions( $s );
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
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-pagination', ark_wp_kses( __('Show navigation', 'ark' ) ), 1);
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
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'lg', 'Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '3')
					->addSelectValue( 1, 1)
					->addSelectValue( 2, 2)
					->addSelectValue( 3, 3)
					->addSelectValue( 4, 4)
					->addSelectValue( 5, 5)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom horizontal gap between columns (in px)', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Blog Post Background', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-bg', '', '#ebeef6')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Borders Vertical', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'dots', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Navigation Dots', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'dots-active', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Navigation Dot Active', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'date-text-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Date', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'date-text-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Date Hover', 'ark' ) ) );

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
	protected function _prepareWPQueryForRendering( $query ) {

	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		wp_enqueue_script( 'ark-equal-height' );

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
			$dataSlider['autoplay'] = $query->get('autoplay-speed');
		}else{
			$dataSlider['autoplay'] = false;
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

		$width = false;
		$height  = false;

		switch( $query->getEscAttr('lg') ) {
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

		echo '<section class="blog-simple-slider">';
			echo '<div class="owl-carousel owl-carousel-op-b-blog" data-slider="'. esc_attr($dataSliderJson) .'">';

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
							echo '<div id="post-'. $postID .'" class="'. implode(' ', get_post_class('post-wrapper')) .'" >';


								echo '<div class="op-b-blog op-b-blog-equal-height">';

									foreach( $query->get('content') as $postItem ) {
										switch( $postItem->getVariationType() ) {

											case 'featured-area':
												if ( empty( $featured_area ) ){
													$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
														->setParam('post-id', $postID)
														->setParam('width', $width)
														->setParam('height', $height)
														->setParam('css-class', 'ff-featured-area')
														->imgIsResponsive()
														->render( $postItem );
												} else {
													echo ( $featured_area );
												}
												break;

											case 'title':
												echo '<h2 class="op-b-blog-title">';
													if( $postItem->get('has-date') ) {
														$beforeTitle = '<span class="simple-slider-date">'. get_the_date( $postItem->getEscAttr('date-format') ) .'</span>';
													}

													$this->_printPostTitle( $postItem, array( 'before-title'=> $beforeTitle, 'link-css-class'=> 'op-b-blog-title-link') );
												echo '</h2>';
												break;

											case 'p-content':
												echo '<div class="blog-simple-slider-post-content">';
													$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
												echo '</div>';
												break;

											case 'meta-data':
												echo '<div class="blog-grid-supplemental">';
													echo '<span class="blog-grid-supplemental-title">';
														$this->_renderMetaElement( $postItem );
													echo '</span>';
												echo '</div>';
												break;

											case 'button':
												echo '<div class="ff-blog-simple-slider-button">';
												$postURL = esc_url( get_permalink() );
												$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($postItem);
												echo '</div>';
												break;
										}
									}

								echo '</div>';

							echo '</div>';
							$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
						echo '</div>';

					}
				}

			echo '</div>';
		echo '</section>';

		$spaceHorizontal = $query->get('space');

		if( $spaceHorizontal != '' ) {
			$spaceHorizontal = floatval( $spaceHorizontal );
			$oneHalf = $spaceHorizontal / 2;

			$this->_getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .ffb-post-wrapper', false)
				->addParamsString('padding-left: '.$oneHalf.'px; padding-right:'.$oneHalf.'px');

		}

		/* COLORS */

		if( $query->getColor('content-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .ffb-post-wrapper', false)
				->addParamsString('background-color: '.$query->getColor('content-bg').';');
		}

		if( $query->getColor('border-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .ffb-post-wrapper', false)
				->addParamsString('border-right: 1px solid '.$query->getColor('border-bg').';');
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
				->addParamsString('border-color: '.$query->getColor('dots-active').' !important;');
		}

		if( $query->getColor('dots-active') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-dots .owl-dot.active span', false)
				->addParamsString('background-color: '.$query->getColor('dots-active').' !important;');
		}

		if( $query->getColor('date-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-op-b-blog .op-b-blog-title a .simple-slider-date', false)
				->addParamsString('color: '.$query->getColor('date-text-color').';');
		}

		if( $query->getColor('date-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-op-b-blog .op-b-blog-title a:hover .simple-slider-date', false)
				->addParamsString('color: '.$query->getColor('date-text-hover-color').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-op-b-blog .op-b-blog-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-op-b-blog .op-b-blog-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-op-b-blog .blog-simple-slider-post-content', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-op-b-blog .blog-simple-slider-post-content p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-op-b-blog .blog-simple-slider-post-content a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .owl-carousel-op-b-blog .blog-simple-slider-post-content a:hover', false)
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

				query.addHeadingSm( 'lg', 'Blog columns: ');
				query.addBreak();
				query.addBreak();

				query.get('content').each(function(query, variationType ){
					switch(variationType){
						case 'title':
							query.addPlainText( 'Post Title With Date' );
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