<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_timeline.html#scrollTo__397
 * */

class ffElBlogTimeline2 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-timeline-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Timeline 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, timeline 2');
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

					/* TYPE META-DATA */
					$s->startRepVariationSection('meta-data', ark_wp_kses( __('Meta Data', 'ark' ) ) );
						$this->_getElementMetaOptions( $s );
					$s->endRepVariationSection();

					/* TYPE POST TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Post Title', 'ark' ) ) );
						$this->_injectTitleOptions( $s );
					$s->endRepVariationSection();

					/* TYPE POST CONTENT */
					$s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ) );
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Top Icon', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-top-icon', ark_wp_kses( __('Show Icon on top of the timeline', 'ark' ) ), 1);
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->startHidingBox('use-top-icon', 'checked');
					$s->startAdvancedToggleBox('top-icon', 'Icon');
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-angle-down');
					$s->endAdvancedToggleBox();
				$s->endHidingBox();				
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Layout', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'grid-layout', '', '0')
					->addSelectValue( esc_attr( __('First Post on the Left side', 'ark' ) ), '0')
					->addSelectValue( esc_attr( __('First Post on the Right side', 'ark' ) ), '1')
					->addSelectValue( esc_attr( __('All Posts on the Left side', 'ark' ) ), '2')
					->addSelectValue( esc_attr( __('All Posts on the Right side', 'ark' ) ), '3')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
		
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Columns Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space-vertical', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom vertical gap between columns (in px)', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'timeline', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Timeline Vertical Line Color', 'ark' ) ) );
					
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'pointer-bg', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Timeline Dot Background', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'pointer-border', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Timeline Dot Border', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'top-icon-text-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Top Icon', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'top-icon-bg-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Top Icon Background', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg', '', '#ffffff')
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

		echo '<section class="blog-timeline-2 '.$gridLayout.'">';
			echo '<div class="timeline-v4" data-grid-layout="' . $query->get('grid-layout') .'">';

				if( $wpQuery->have_posts() ) {
					while( $wpQuery->have_posts() ) {
						$wpQuery->the_post();

						ark_Featured_Area::setSizes( 1, $width, $height );
						$featured_area = ark_Featured_Area::getFeaturedArea();

						$postID = get_the_ID();

							echo '<div class="timeline-v4-list-item">';

								echo '<i class="timeline-v4-badge-icon radius-circle"></i>';
								$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
								echo '<div id="post-'. $postID .'" class="timeline-v4-panel '. implode(' ', get_post_class('post-wrapper')) .'">';

									foreach( $query->get('content') as $oneContent ) {
										switch( $oneContent->getVariationType() ) {

											case 'title':
												echo '<h3 class="timeline-v4-title">';
													$this->_printPostTitle( $oneContent, array('link-css-class' => 'timeline-v4-title-link') );
												echo '</h3>';
												break;

											case 'featured-area':
												if ( empty( $featured_area ) ){
													$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
														->setParam('post-id', $postID)
														->setParam('css-class', 'timeline-v4-featured-image')
														->setParam('width', $width)
														->setParam('height', $height)
														->imgIsResponsive()
														->imgIsFullWidth()
														->render( $oneContent );
												} else {
													echo ( $featured_area );
												}
												break;

											case 'p-content':
												$this->_applySystemTabsOnRepeatableStart( $oneContent );
												echo '<div class="blog-timeline-2-text">';
													$this->_getBlock( ffThemeBlConst::CONTENT )->render( $oneContent );;
												echo '</div>';
												$this->_applySystemTabsOnRepeatableEnd( $oneContent );
												break;
//
											case 'meta-data':

												echo '<span class="timeline-v4-subtitle">';
													$this->_renderMetaElement( $oneContent );
												echo '</span>';

												break;

											case 'button':
												echo '<div class="blog-timeline-2-button-wrapper">';
													$postURL = esc_url( get_permalink() );
													$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($oneContent);
												echo '</div>';
												break;

										}
									}

								echo '</div>';
								$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
							echo '</div>';

					}
				}

				if ( $query->get('use-top-icon') ){
					$this->_advancedToggleBoxStart( $query, 'top-icon');
					echo '<div class="timeline-v4-top-icon '.$query->getWpKses('top-icon icon').'"> </div>';
					$this->_advancedToggleBoxEnd( $query, 'top-icon');
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
				->addSelector('.timeline-v4-list-item')
				->addParamsString('margin-top:' . $spaceVertical . 'px;');
		}

		/* COLORS */

		if( $query->getColor('timeline') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4:before', false)
				->addParamsString('background-color: '.$query->getColor('timeline').';');
		}

		if( $query->getColor('pointer-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4 .timeline-v4-badge-icon', false)
				->addParamsString('background-color: '.$query->getColor('pointer-bg').';');
		}

		if( $query->getColor('pointer-border') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4 .timeline-v4-badge-icon', false)
				->addParamsString('border-color: '.$query->getColor('pointer-border').';');
		}

		if( $query->getColor('top-icon-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4-top-icon', false)
				->addParamsString('color: '.$query->getColor('top-icon-text-color').';');
		}

		if( $query->getColor('top-icon-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4-top-icon', false)
				->addParamsString('background-color: '.$query->getColor('top-icon-bg-color').';');
		}

		if( $query->getColor('content-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4-panel', false)
				->addParamsString('background-color: '.$query->getColor('content-bg').';');
		}

		if( $query->getColor('content-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4 .timeline-v4-list-item .timeline-v4-panel:after', false)
				->addParamsString('border-color: transparent transparent transparent '.$query->getColor('content-bg').';');
		}

		if( $query->getColor('content-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4 .timeline-v4-list-item .timeline-v4-panel:before', false)
				->addParamsString('border-color: transparent '.$query->getColor('content-bg').' transparent transparent;');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4 .timeline-v4-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4 .timeline-v4-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4 .blog-timeline-2-text', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4 .blog-timeline-2-text p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4 .blog-timeline-2-text a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4 .blog-timeline-2-text a:hover', false)
				->addParamsString('color: '.$query->getColor('content-link-hover-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4-subtitle .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4-subtitle .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4-subtitle .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4-subtitle .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .timeline-v4-subtitle .ff-meta-icon', false)
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