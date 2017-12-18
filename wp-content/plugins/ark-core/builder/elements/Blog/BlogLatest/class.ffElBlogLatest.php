<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_teaser_2_col.html#scrollTo__1800
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_teaser_3_col.html#scrollTo__1800
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_teaser_4_col.html#scrollTo__1800
 * */

class ffElBlogLatest extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-latest');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Latest', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_addTab('Loop', array($this, '_wpLoopSettings'));
		$this->_addTab('Pagination', array($this, '_wpPagination'));

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('- No support for multimedia <strong>Featured Area</strong>, only <strong>Featured Images</strong>', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post', 'ark' ) ) );
				$s->startCssWrapper('ffb-post-wrapper');
				$s->startRepVariableSection('content');

					/* TYPE SPACER */
					$s->startRepVariationSection('spacer', ark_wp_kses( __('Spacer', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'spacer-size', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom Height of Spacer (in px)', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* TYPE POST TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Post Title', 'ark' ) ));
						$this->_injectTitleOptions( $s );
					$s->endRepVariationSection();

					/* TYPE SEPARATOR */
					$s->startRepVariationSection('separator', ark_wp_kses( __('Divider', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Color', 'ark' ) ) );
					$s->endRepVariationSection();

					/* TYPE META-DATA */
					$s->startRepVariationSection('meta-data', ark_wp_kses( __('Meta Data', 'ark' ) ));
						$this->_getElementMetaOptions( $s );
					$s->endRepVariationSection();

					/* TYPE POST CONTENT */
					$s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
					$s->endRepVariationSection();

					/* TYPE META-DATA */
					$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ));
						$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('no-link-options', true)->injectOptions($s);
					$s->endRepVariationSection();

				$s->endRepVariableSection();
				$s->endCssWrapper();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Featured Image', 'ark' ) ) );
				$this->_getBlock( ffThemeBlConst::FEATUREDIMG )->withoutImgLink()->injectOptions( $s );
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'image-hover-effect', 'Show zoom animation on hover', 1 );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post Wrapper', 'ark' ) ) );

				$s->startAdvancedToggleBox('post-wrapper', 'Blog Post Wrapper');

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This is the Blog Post Wrapper that you can edit and style');
					$s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Link Overlay', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'is-clickable', 'Use Link Overlay', 0 );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('If enabled, clicking on the whole blog post will take you to a single post page.', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$this->_injectColumnOptions( $s, array('xs'=>1,'sm'=>2,'md'=>3,'lg'=>3));

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-color', '', 'rgba(52, 52, 60, 0.4)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Featured Image Overlay', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-color-hover', '', '[2]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Featured Image Overlay Hover', 'ark' ) ) );

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
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider', 'ark' ) ) );

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

		$cols = $this->_calculateColumnOptions( $query );

		$width = false;
		$height  = false;

		switch( $query->getEscAttr('grid lg') ) {
			case 1:
				$width = 1440;
				$height =  false;
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
		
		echo '<section class="blog-latest '.$query->getWpKses('content-align').'">';
			echo '<div class="fg-row fg-blog-row-main row blog-content fg-row-match-cols">';
			if( $wpQuery->have_posts() ) {

				$postIndex = 1;

				while( $wpQuery->have_posts() ) {

					$wpQuery->the_post();

					if( !$loopBlock->canBePostPrinted() ) {
						continue;
					}

					$postID = get_the_ID();

					$postURL = esc_url( get_permalink() );

					echo '<div class="fg-col fg-blog-col-main col-xs-12 '. $cols .'">';

						$zoomEffect = '';
						if( $query->get('image-hover-effect') ) {
							$zoomEffect = 'blog-teaser-v2-zoom';
						}
						$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
						echo '<div id="post-'. $postID .'" class="'. implode(' ', get_post_class('post-wrapper')) .' '.$zoomEffect.'" >';

							echo '<div class="fg-match-column-inside-wrapper">';
								echo '<article class="blog-teaser-v2">';
									echo '<div class="blog-teaser-v2-content">';

										foreach( $query->get('content') as $postItem ) {
											switch( $postItem->getVariationType() ) {

												case 'spacer':
													if( $postItem->get('spacer-size') ) {
														$this->getAssetsRenderer()->createCssRule()
															->setAddWhiteSpaceBetweenSelectors(false)
															->addSelector('.blog-teaser-v2-spacer', false)
															->addParamsString('height: '.$postItem->get('spacer-size').'px;');
													}

													echo '<div class="blog-teaser-v2-spacer"></div>';
													break;

												case 'title':
													echo '<h2 class="blog-teaser-v2-title blog-teaser-v2-title-sm">';
														$this->_printPostTitle( $postItem );
													echo '</h2>';
													break;

												case 'separator':

													echo '<div class="blog-teaser-v2-separator"></div>';
													$this->_renderCSSRule('background-color', $postItem->getColor('divider-color') );
													break;

												case 'meta-data':
													echo '<div class="blog-teaser-v2-meta-data-style">';
														$this->_renderMetaElement($postItem);
													echo '</div>';
													break;

												case 'p-content':
													echo '<div class="blog-teaser-v2-post-content">';
													$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
													echo '</div>';
													break;

												case 'button':
													echo '<div class="blog-teaser-v2-buttons">';
														$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($postItem);
													echo '</div>';
													break;

											}
										}

									echo '</div>';


								echo '</article>';
							echo '</div>';

							echo '<div class="blog-teaser-v2-bg">';
								echo '<div class="blog-teaser-v2-bg-inner" style="background-image: url('
									. $this->_getBlock( ffThemeBlConst::FEATUREDIMG )->setParam('post-id', $postID)->setParam('width', $width)->setParam('height', $height)->setParam('get-url', true)->render( $query )
									. ');">';
								echo '</div>';
							echo '</div>';

							if( $query->get('is-clickable') ) {
								echo '<a class="blog-teaser-v2-link" href="'. esc_url( get_permalink() ) .'"></a>';
							}

						echo '</div>';
						$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
					echo '</div>';

					$this->_printClearFixDiv( $query, $postIndex );

					$postIndex++;

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


		/* COLORS */

		if( $query->getColor('overlay-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .post-wrapper .blog-teaser-v2-bg-inner:after', false)
				->addParamsString('background-color: '.$query->getColor('overlay-color').';');
		}

		if( $query->getColor('overlay-color-hover') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .post-wrapper:hover .blog-teaser-v2-bg-inner:after', false)
				->addParamsString('background-color: '.$query->getColor('overlay-color-hover').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-separator', false)
				->addParamsString('background-color: '.$query->getColor('separator-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-content .blog-teaser-v2-post-content', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-content .blog-teaser-v2-post-content p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-content .blog-teaser-v2-post-content a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-content .blog-teaser-v2-post-content a:hover', false)
				->addParamsString('color: '.$query->getColor('content-link-hover-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-meta-data-style .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-meta-data-style .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-meta-data-style .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-meta-data-style .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-teaser-v2-meta-data-style .ff-meta-icon', false)
				->addParamsString('color: '.$query->getColor('meta-icon-color').';');
		}

		$loopBlock->resetOnTheEnd();
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				query.addHeadingSm( 'grid md', 'Blog columns: ');
				query.addBreak();
				if( query.exists('content') ) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'meta-data':
								query.addPlainText('Meta Data');
								query.addBreak();
								break;
							case 'title':
								query.addPlainText('Post Title');
								query.addBreak();
								break;
							case 'p-content':
								query.addPlainText('Post Content');
								query.addBreak();
								break;
							case 'separator':
								query.addDivider();
								query.addBreak();
								break;
							case 'button':
								blocks.render('button', query);
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