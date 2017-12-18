<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_timeline.html#scrollTo__2760
 * */

class ffElBlogTimeline1 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-timeline-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Timeline 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, timeline 1');
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
					$s->startRepVariationSection('separator', ark_wp_kses( __('Divider', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('This is a Divider', 'ark' ) ) );
						$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="hidden">' );
							$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank');
						$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Posts Layout', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'grid-layout', '', '0')
					->addSelectValue( esc_attr( __('First Post on the Left side', 'ark' ) ), '0')
					->addSelectValue( esc_attr( __('First Post on the Right side', 'ark' ) ), '1')
					->addSelectValue( esc_attr( __('All Posts on the Left side', 'ark' ) ), '2')
					->addSelectValue( esc_attr( __('All Posts on the Right side', 'ark' ) ), '3')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Columns Settings', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space-vertical', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom vertical gap between columns (in px)', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'timeline', '', '#69697b')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Timeline Vertical Line Color', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'timeline-post-line', '', '#757589')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Timeline Horizontal Line Color', 'ark' ) ) );
					
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'pointer-bg', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Timeline Dot Background', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'pointer-border', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Timeline Dot Border', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Blog Post Background', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'post-shadow', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Blog Post Shadow', 'ark' ) ) );
					
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link Hover', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'separator-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Horizontal Divider', 'ark' ) ) );

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
	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$loopBlock = $this->_getBlock( ffThemeBuilderBlock::LOOP );
		/**
		 * @var $wpQuery WP_Query
		 */
		$wpQuery = $loopBlock->get( $query );

		$this->_printLoopVarDump( $loopBlock );

		$width = false;
		$height  = false;

		if ( '2' == $query->get('grid-layout') || '3' == $query->get('grid-layout') ){
			$width = 1440;
		} else {
			$width = 768;
		}

		$gridLayout = 'grid-layout-'.$query->get('grid-layout');

		echo '<section class="blog-timeline-1 '.$gridLayout.'">';
		echo '<div class="timeline-v3" data-grid-layout="' . $query->get('grid-layout') .'">';

			if( $wpQuery->have_posts() ) {
				while( $wpQuery->have_posts() ) {
					$wpQuery->the_post();

					ark_Featured_Area::setSizes( 1, $width, $height );
					$featured_area = ark_Featured_Area::getFeaturedArea();

					$postID = get_the_ID();

						echo '<div class="timeline-v3-list-item">';
							$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
							echo '<div id="post-'. $postID .'" class="'. implode(' ', get_post_class('post-wrapper')) .'" >';

								echo '<i class="timeline-v3-badge-icon radius-circle"></i>';
								echo '<div class="timeline-v3-badge"></div>';
								echo '<div class="timeline-v3-panel">';

									echo '<article class="blog-grid">';

										$isInBoxShadow = false;
										$isInBlogGrid = false;

										foreach( $query->get('content') as $oneContent ) {
											switch( $oneContent->getVariationType() ) {

												case 'featured-area':
													if( $isInBlogGrid){ echo '</div>'; $isInBlogGrid = false; }
													if( $isInBoxShadow){ echo '</div>'; $isInBoxShadow = false; }

													$this->_applySystemTabsOnRepeatableStart( $oneContent );
													if ( empty( $featured_area ) ){
														// Escaped featured image
														echo (
															$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
																->setParam('post-id', $postID)
																->setParam('width', $width)
																->setParam('height', $height)
																->imgIsResponsive()
																->imgIsFullWidth()
																->render( $oneContent )
														);
													} else {
														// Escaped featured area
														echo ( $featured_area );
													}
													$this->_applySystemTabsOnRepeatableEnd( $oneContent );

													break;

												case 'title':
													if( ! $isInBoxShadow){ echo '<div class="blog-grid-box-shadow">'; $isInBoxShadow = true; }
													if( ! $isInBlogGrid){ echo '<div class="blog-grid-content">'; $isInBlogGrid = true; }

													$this->_applySystemTabsOnRepeatableStart( $oneContent );
													echo '<h2 class="blog-grid-title-md">';
														$this->_printPostTitle( $oneContent );
													echo '</h2>';
													$this->_applySystemTabsOnRepeatableEnd( $oneContent );

													break;

												case 'p-content':
													if( ! $isInBoxShadow){ echo '<div class="blog-grid-box-shadow">'; $isInBoxShadow = true; }
													if( ! $isInBlogGrid){ echo '<div class="blog-grid-content">'; $isInBlogGrid = true; }

													$this->_applySystemTabsOnRepeatableStart( $oneContent );
													echo '<div class="blog-timeline-1-text">'
														. $this->_getBlock( ffThemeBlConst::CONTENT )->get( $oneContent )
														. '</div>';
													$this->_applySystemTabsOnRepeatableEnd( $oneContent );

													break;

												case 'separator':
													if( ! $isInBoxShadow){ echo '<div class="blog-grid-box-shadow">'; $isInBoxShadow = true; }
													if( $isInBlogGrid){ echo '</div>'; $isInBlogGrid = false; }

													$this->_applySystemTabsOnRepeatableStart( $oneContent );
													echo '<div class="blog-grid-separator"></div>';
													$this->_applySystemTabsOnRepeatableEnd( $oneContent );

													break;

												case 'meta-data':
													if( ! $isInBoxShadow){ echo '<div class="blog-grid-box-shadow">'; $isInBoxShadow = true; }
													if( $isInBlogGrid){ echo '</div>'; $isInBlogGrid = false; }

													echo '<div class="blog-grid-supplemental">';
														echo '<div class="blog-grid-supplemental-title">';
															$this->_applySystemTabsOnRepeatableStart( $oneContent );
																// escaped post metas
																echo ( $this->_renderMetaElement($oneContent, array('link-class' => 'blog-grid-supplemental-category') ) );
															$this->_applySystemTabsOnRepeatableEnd( $oneContent );
														echo '</div>';
													echo '</div>';

													break;

												case 'button':
													if( ! $isInBoxShadow){ echo '<div class="blog-grid-box-shadow">'; $isInBoxShadow = true; }
													if( ! $isInBlogGrid){ echo '<div class="blog-grid-content">'; $isInBlogGrid = true; }

													$this->_applySystemTabsOnRepeatableStart( $oneContent );
													echo '<div class="blog-timeline-1-button-wrapper">';
														$postURL = esc_url( get_permalink() );
														$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($oneContent);
													echo '</div>';
													$this->_applySystemTabsOnRepeatableEnd( $oneContent );

													break;

											}
										}

										if( $isInBoxShadow){ echo '</div>'; }
										if( $isInBlogGrid){ echo '</div>'; }

									echo '</article>';

								echo '</div>';
							echo '</div>';
							$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
						echo '</div>';

				}
			}

		echo '</div>';

		$paginationBlock = $this->_getBlock( ffThemeBlConst::PAGINATION )->setParam(ffBlPagination::PARAM_POST_GRID_UNIQUE_ID, $uniqueId)->setWpQuery( $wpQuery );

		if( $paginationBlock->showPagination( $query ) ) {
			echo '<div class="blog-pagination row">';
			echo '<div class="col-xs-12">';
			$paginationBlock->render($query);
			echo '</div>';
			echo '</div>';
		}

		echo '</section>';



		$spaceVertical = $query->get('space-vertical');

		if( $spaceVertical != '' ) {
			$spaceVertical = absint( $spaceVertical );

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.timeline-v3-list-item')
				->addParamsString('margin-top:' . $spaceVertical . 'px;');
		}

		/* COLORS */

		if( $query->getColor('timeline') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v3:before', false)
				->addParamsString('background-color: '.$query->getColor('timeline').';');
		}

		if( $query->getColor('timeline-post-line') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v3 .timeline-v3-badge:before', false)
				->addParamsString('border-color: '.$query->getColor('timeline-post-line').';');
		}

		if( $query->getColor('pointer-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v3 .timeline-v3-badge-icon', false)
				->addParamsString('background-color: '.$query->getColor('pointer-bg').';');
		}

		if( $query->getColor('pointer-border') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v3 .timeline-v3-badge-icon', false)
				->addParamsString('border-color: '.$query->getColor('pointer-border').';');
		}

		if( $query->getColor('content-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid', false)
				->addParamsString('background-color: '.$query->getColor('content-bg').';');
		}

		if( $query->getColorWithoutComparationDefault('post-shadow', '') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-box-shadow', false)
				->addParamsString('box-shadow: 0 2px 5px 3px '.$query->getColorWithoutComparationDefault('post-shadow', '').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v3 .blog-grid-title-md a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v3 .blog-grid-title-md a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-separator', false)
				->addParamsString('border-color: '.$query->getColor('separator-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v3 .blog-timeline-1-text', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v3 .blog-timeline-1-text p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v3 .blog-timeline-1-text a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v3 .blog-timeline-1-text a:hover', false)
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

				query.get('content').each(function(query, variationType ){
					switch(variationType){

						case 'title':
							query.addPlainText( 'Post Title' );
							query.addBreak();
							break;
						case 'featured-area':
							query.addPlainText( 'Featured Area' );
							query.addBreak();
							break;
						case 'separator':
							query.addDivider();
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