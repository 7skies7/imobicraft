<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_vertical_menu_one_page.html#scrollTo__4800
 * */

class ffElBlogSimple2 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-simple-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Simple 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, simple 2');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_addTab('Loop', array($this, '_wpLoopSettings'));
		$this->_addTab('Pagination', array($this, '_wpPagination'));

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('- No support for <strong>Grid Columns</strong> customization, all blog posts are rendered in one column', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post', 'ark' ) ) );
				$s->startCssWrapper('ffb-post-wrapper');
				$s->startRepVariableSection('content');

					/* TYPE SEPARATOR */
					$s->startRepVariationSection('divider', ark_wp_kses( __('Divider', 'ark' ) ));
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('This is a Divider', 'ark' ) ) );
					$s->endRepVariationSection();

					/* TYPE POST TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Post Title', 'ark' ) ) );
						$this->_injectTitleOptions( $s );
					$s->endRepVariationSection();

					/* TYPE POST CONTENT */
					$s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
					$s->endRepVariationSection();

					/* TYPE LINK */
					$s->startRepVariationSection('link', ark_wp_kses( __('Link', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Explore Story')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-long-arrow-right')
						;
					$s->endRepVariationSection();

					/* TYPE META DATA */
					$s->startRepVariationSection('meta', ark_wp_kses( __('Meta Data', 'ark' ) ) )
						->addParam('hide-default', true);
						;
						$this->_getElementMetaOptions( $s );
					$s->endRepVariationSection();

					/* TYPE BUTTON */
					$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::BUTTON )->setParam('no-link-options', true)->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();
				$s->endCssWrapper();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Featured Area', 'ark' ) ) );

				$s->startCssWrapper('ffb-post-wrapper');
					$s->startAdvancedToggleBox('one-featured-area', 'Featured Area');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('NOTE: The settings below are only for the <strong>Featured Image</strong> case', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$this->_getBlock( ffThemeBlConst::FEATUREDIMG )->injectOptions( $s );
					$s->endAdvancedToggleBox();
				$s->endCssWrapper();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post Wrapper', 'ark' ) ) );

				$s->startAdvancedToggleBox('post-wrapper', 'Blog Post Wrapper');

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This is the Blog Post Wrapper that you can edit and style');
					$s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Columns Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space-vertical', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom vertical gap between columns (in px)', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'big-separator', '', '#eeeeee')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Separator between Blog Posts', 'ark' ) ) );

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

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'read-more-link-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Read More Link Text', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'read-more-link-text-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Read More Link Text Hover', 'ark' ) ) );

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
	protected function _prepareWPQueryForRendering( $query ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$loopBlock = $this->_getBlock( ffThemeBuilderBlock::LOOP );
		/**
		 * @var $wpQuery WP_Query
		 */
		$wpQuery = $loopBlock->get( $query );

		$this->_printLoopVarDump( $loopBlock );

		$postNumber = 1;

		$isFirstPost = true;

		echo '<section class="blog-simple-2">';

			if( $wpQuery->have_posts() ) {
				while( $wpQuery->have_posts() ) {

					$wpQuery->the_post();

					if( !$loopBlock->canBePostPrinted() ) {
						continue;
					}

					ark_Featured_Area::setSizes( 1, 800, false );
					$featured_area = ark_Featured_Area::getFeaturedArea();

					$postID = get_the_ID();

					if ( !$isFirstPost ){
						echo '<div class="blog-simple-2-separator"></div>';
					}

					$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
					echo '<div id="post-'. $postID .'" class="'. implode(' ', get_post_class('post-wrapper')) .'" >';
						echo '<div class="row">';

							if( 1 & $postNumber ) {
								echo '<div class="col-sm-6">';
							} else {
								echo ' <div class="col-sm-6 col-md-push-6">';
							}

							$this->_advancedToggleBoxStart( $query, 'one-featured-area');
							if ( empty( $featured_area ) ){
								 	$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
								 		->setParam('post-id', $postID)
								 		->setParam('width', 768)
								 		->setParam('height', false)
								 		->imgIsResponsive()
								 		->render( $query->getMustBeQueryNotEmpty('one-featured-area') );
							} else {
								echo ( $featured_area );
							}
							$this->_advancedToggleBoxEnd( $query, 'one-featured-area');

							echo '</div>';

							$position = '';
							if( 1 & $postNumber ) {
								echo '<div class="col-sm-6">';
								$position = 'left';
							} else {
								echo ' <div class="col-sm-6 col-md-pull-6">';
								$position = 'right';
							}

								echo '<div class="news-v4 text-'. $position .'">';

									foreach( $query->get('content') as $postItem ) {
										switch( $postItem->getVariationType() ) {

											case 'divider':
												echo '<div class="blog-simple-2-divider"></div>';
												break;

											case 'title':
												echo '<h2 class="news-v4-title news-v4-title-element-'. $position .'">';
													$this->_printPostTitle( $postItem );
												echo '</h2>';
												break;

											case 'p-content':
												echo '<div class="blog-simple-2-post-content">';
													$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
												echo '</div>';
												break;

											case 'link':
												echo '<a href="'. esc_url( get_permalink() ) .'" class="blog-simple-2-link news-v4-read-more-link">'. $postItem->getWpKses('text') .'&nbsp;<i class="'. $postItem->getEscAttr('icon') .'"></i></a>';
												break;

											case 'meta':
												echo '<div class="blog-grid-supplemental-title">';
													$this->_renderMetaElement( $postItem );
												echo '</div>';
												break;

											case 'button':
												$postURL = esc_url( get_permalink() );
												echo '<div class="blog-grid-button">';
												$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($postItem);
												echo '</div>';
												break;

										}
									}

								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
					$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );

					$postNumber++;

					$isFirstPost = false;

				}
			}

		echo '</section>';

		$this->_getBlock( ffThemeBlConst::PAGINATION )->setWpQuery( $wpQuery )->render( $query );


		$spaceVertical = $query->get('space-vertical');

		if( $spaceVertical != '' ) {
			$spaceBetweenColumns = floatval($spaceVertical);
			$oneHalf = $spaceBetweenColumns / 2;

			$css = '';
			$css .= 'margin-top:' . $oneHalf .'px;' . PHP_EOL;
			$css .= 'margin-bottom:' .$oneHalf .'px;';

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.blog-simple-2-separator')
				->addParamsString($css);
		}

		/* COLORS */

		if( $query->getColor('big-separator') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-2-separator', false)
				->addParamsString('border-top: 1px solid '.$query->getColor('big-separator').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-2-divider', false)
				->addParamsString('background-color: '.$query->getColor('separator-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4 .blog-simple-2-post-content', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4 .blog-simple-2-post-content p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4 .blog-simple-2-post-content a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4 .blog-simple-2-post-content a:hover', false)
				->addParamsString('color: '.$query->getColor('content-link-hover-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental-title .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental-title .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental-title .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental-title .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental-title .ff-meta-icon', false)
				->addParamsString('color: '.$query->getColor('meta-icon-color').';');
		}
		
		if( $query->getColor('read-more-link-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-2-link', false)
				->addParamsString('color: '.$query->getColor('read-more-link-text-color').';');
		}

		if( $query->getColor('read-more-link-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-2-link:hover', false)
				->addParamsString('color: '.$query->getColor('read-more-link-text-hover-color').';');
		}

		$loopBlock->resetOnTheEnd();

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {
				if( query.exists('content') ) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addPlainText('Post Title');
								query.addBreak();
								break;
							case 'p-content':
								query.addPlainText('Post Content');
								query.addBreak();
								break;
							case 'link':
								query.addText('text', 'Post link: ');
								query.addIcon('icon', 'Link icon: ');
								query.addBreak();
								break;

							case 'button':
								blocks.render('button', query);
								query.addBreak();
								break;

							case 'meta':
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