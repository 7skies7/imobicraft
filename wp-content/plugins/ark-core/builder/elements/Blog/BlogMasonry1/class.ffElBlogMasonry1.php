<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_fullwidth.html
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_2_col.html
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_3_col.html
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_grid_4_col.html
 * */

class ffElBlogMasonry1 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-masonry-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Masonry 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, masonry 1');
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

					/* TYPE POST CONTENT */
					$s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
					$s->endRepVariationSection();

					/* TYPE SEPARATOR */
					$s->startRepVariationSection('separator', ark_wp_kses( __('Divider', 'ark' ) ));
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('This is a Divider', 'ark' ) ) );
					$s->endRepVariationSection();

					/* TYPE META-DATA */
					$s->startRepVariationSection('meta-data', ark_wp_kses( __('Meta Data', 'ark' ) ) );
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Grid Layout', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'grid-layout', '', '3')
					->addSelectValue( esc_attr( __('1 Column', 'ark' ) ), '1')
					->addSelectValue( esc_attr( __('2 Columns', 'ark' ) ), '2')
					->addSelectValue( esc_attr( __('3 Columns', 'ark' ) ), '3')
					->addSelectValue( esc_attr( __('4 Columns', 'ark' ) ), '4')
					->addSelectValue( esc_attr( __('6 Columns', 'ark' ) ), '6')
				;

				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom horizontal gap between columns (in px)', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space-vertical', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom vertical gap between columns (in px)', 'ark' ) ) );

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

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Inner Links', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Inner Links Hover', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'separator-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Horizontal Divider', 'ark' ) ) );

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


	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		wp_enqueue_script( 'ark-masonry' );

		$loopBlock = $this->_getBlock( ffThemeBuilderBlock::LOOP );
		/**
		 * @var $wpQuery WP_Query
		 */
		$wpQuery = $loopBlock->get( $query );

		$this->_printLoopVarDump( $loopBlock );

		$width = false;
		$height  = false;

		switch( $query->getEscAttr('grid-layout') ) {
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


		echo '<section class="blog-masonry-1" >';
			echo'<div class="masonry-wrapper">';
			echo '<div class="masonry-grid" data-custom-gap-space="0">';
			if( $wpQuery->have_posts() ) {
				while( $wpQuery->have_posts() ) {

					$wpQuery->the_post();

					if( !$loopBlock->canBePostPrinted() ) {
						continue;
					}

					ark_Featured_Area::setSizes( 1, $width, $height );
					$featured_area = ark_Featured_Area::getFeaturedArea();


					$postID = get_the_ID();
					$postURL = esc_url( get_permalink() );

					echo '<div class="masonry-grid-item col-' . $query->getEscAttr('grid-layout') . '">';
						$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
						echo '<div id="post-'. $postID .'" class="'. implode(' ', get_post_class('post-wrapper')) .' '.$query->getWpKses('content-align').'">';
							echo '<article class="blog-grid">';

								$isInBoxShadow = false;
								$isInBlogGrid = false;

								foreach( $query->get('content') as $oneContent ) {
									switch( $oneContent->getVariationType() ) {

										case 'title':
											if( !$isInBoxShadow ){ echo '<div class="blog-grid-box-shadow">'; $isInBoxShadow = true; }
											if( !$isInBlogGrid ){ echo '<div class="blog-grid-content">'; $isInBlogGrid = true; }

											$this->_applySystemTabsOnRepeatableStart( $oneContent );
											echo '<h2 class="blog-masonry-1-title masonry1 blog-grid-title-md">';
												$this->_printPostTitle( $oneContent );
											echo '</h2>';
											$this->_applySystemTabsOnRepeatableEnd( $oneContent );


											break;

										case 'featured-area':
											if( $isInBlogGrid ){ echo '</div>'; $isInBlogGrid = false; }
											if( $isInBoxShadow ){ echo '</div>'; $isInBoxShadow = false; }

											$this->_applySystemTabsOnRepeatableStart( $oneContent );
											if ( empty( $featured_area ) ){
												$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
													->setParam('post-id', $postID)
													->setParam('width', $width)
													->setParam('height', $height)
													->imgIsResponsive()
													->render( $oneContent );
											} else {
												echo ( $featured_area );
											}
											$this->_applySystemTabsOnRepeatableEnd( $oneContent );

											break;

										case 'p-content':
											if( !$isInBoxShadow ){ echo '<div class="blog-grid-box-shadow">'; $isInBoxShadow = true; }
											if( !$isInBlogGrid ){ echo '<div class="blog-grid-content">'; $isInBlogGrid = true; }

											$this->_applySystemTabsOnRepeatableStart( $oneContent );
											echo '<div class="blog-grid-post-content">';
												$this->_getBlock( ffThemeBlConst::CONTENT )->render( $oneContent );
											echo '</div>';
											$this->_applySystemTabsOnRepeatableEnd( $oneContent );

											break;

										case 'button':
											if( !$isInBoxShadow ){ echo '<div class="blog-grid-box-shadow">'; $isInBoxShadow = true; }
											if( $isInBlogGrid ){ echo '</div>'; $isInBlogGrid = false; }

											$this->_applySystemTabsOnRepeatableStart( $oneContent );
											echo '<div class="blog-masonry-1-button-wrapper">';
											$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($oneContent);
											echo '</div>';

											$this->_applySystemTabsOnRepeatableEnd( $oneContent );
											break;

											break;

										case 'separator':
											if( !$isInBoxShadow ){ echo '<div class="blog-grid-box-shadow">'; $isInBoxShadow = true; }
											if( $isInBlogGrid ){ echo '</div>'; $isInBlogGrid = false; }

											$this->_applySystemTabsOnRepeatableStart( $oneContent );
											echo '<div class="blog-grid-separator"></div>';
											$this->_applySystemTabsOnRepeatableEnd( $oneContent );

											break;

										case 'meta-data':
											if( !$isInBoxShadow ){ echo '<div class="blog-grid-box-shadow">'; $isInBoxShadow = true; }
											if( $isInBlogGrid ){ echo '</div>'; $isInBlogGrid = false; }

											$this->_applySystemTabsOnRepeatableStart( $oneContent );
											echo '<div class="blog-grid-supplemental">';
												echo '<span class="blog-grid-supplemental-title">';
													$this->_renderMetaElement( $oneContent );
												echo '</span>';
											echo '</div>';
											$this->_applySystemTabsOnRepeatableEnd( $oneContent );

											break;

									}
								}

								if( $isInBoxShadow ){ echo '</div>'; }
								if( $isInBlogGrid ){ echo '</div>'; }

							echo '</article>';
						echo '</div>';
						$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
					echo '</div>';

				}
			}
			echo '</div>';
			echo '</div>';
		echo '</section>';

		$this->_getBlock( ffThemeBlConst::PAGINATION )->setWpQuery( $wpQuery )->render( $query );

		$spaceHorizontal = $query->get('space');

		if( $spaceHorizontal != '' ) {
			$spaceHorizontal = floatval( $spaceHorizontal );
			$oneHalf = $spaceHorizontal / 2;


			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.masonry-grid-item .post-wrapper')
				->addParamsString('margin-left: '.$oneHalf.'px; margin-right:'.$oneHalf.'px');

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.masonry-wrapper')
				->addParamsString('margin-left: -'.$oneHalf.'px; margin-right: -'.$oneHalf.'px');
 
		}

		$spaceVertical = $query->get('space-vertical');

		if( $spaceVertical != '' ) {
			$spaceVertical = absint( $spaceVertical );

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.masonry-grid-item .post-wrapper')
				->addParamsString('margin-bottom:' . $spaceVertical . 'px;');
		}


		/* COLORS */

		if( $query->getColor('content-shadow-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid', false)
				->addParamsString('box-shadow: 0 2px 5px 3px '.$query->getColor('content-shadow-color').';');
		}

		if( $query->getColor('content-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid', false)
				->addParamsString('background-color: '.$query->getColor('content-bg-color').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-masonry-1-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-masonry-1-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid .blog-grid-separator', false)
				->addParamsString('border-color: '.$query->getColor('separator-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid .blog-grid-post-content', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid .blog-grid-post-content p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid .blog-grid-post-content a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid .blog-grid-post-content a:hover', false)
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

				query.addHeadingSm('grid-layout', 'Blog columns: ', '');
				query.addBreak();

				if (query.exists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {

							case 'title':
								query.addPlainText('Post Title');
								query.addBreak();
								break;
							case 'featured-area':
								query.addPlainText('Featured Area');
								query.addBreak();
								break;

							case 'button':
								blocks.render('button', query);
								query.addBreak();
								break;

							case 'separator':
								query.addPlainText('Separator');
								query.addBreak();
								break;
							case 'p-content':
								query.addPlainText('Post Content');
								query.addBreak();
								break;
							case 'meta-data':
								query.addPlainText('Post Meta');
								query.addBreak();
								break;

						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}